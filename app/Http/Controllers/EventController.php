<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    public function index()
    {
        $search = request("search");
        if ($search) {
            $events = Event::where([["title", "like", "%" . $search . '%']])->get();
        } else {
            $events  = Event::all();
        }

        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create()
    {
        $availableItems = ['Cadeiras', 'Open Bar', 'Open Food', 'Sorteios'];
        return view('events.create', ['availableItems' => $availableItems]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'private' => 'required|in:0,1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $event = new Event;
        $event->title = $validated['title'];
        $event->date = $validated['date'];
        $event->city = $validated['city'];
        $event->private = $validated['private'];
        $event->description = $validated['description'] ?? '';

        // Process items: merge selected checkboxes with new items (comma separated)
        $items = $request->items ?? [];
        $newItemsRaw = $request->new_items ?? '';
        $newItems = array_filter(array_map('trim', explode(',', $newItemsRaw)), function ($v) {
            return $v !== '';
        });
        // Merge and normalize (dedupe case-insensitive)
        $allItems = array_values(array_unique(array_merge($items, $newItems)));
        $event->items = $this->normalizeItems($allItems);

        // image upload 
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;

            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;

            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }
        $user = Auth::user();
        $event->user_id = $user->id;

        $event->save();

        return redirect("/")->with("msg", "Evento criado com sucesso.");
    }

    public function createItem(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $items = $event->items;
        $newItems = $request->items;

        foreach ($newItems as $item) {
            array_push($items, $item);
        }

        $event->items = $items;
        $event->save();

        return redirect()->back()->with('msg', 'Itens adicionados com sucesso');
    }


    public function show($id)
    {
        $user = Auth::user();
        $hasUserJoined = false;

        if ($user) {
            $userEvents = $user->eventasparticipant->toArray();

            foreach ($userEvents as $userEvent) {
                if ($userEvent["id"] == $id) {
                    $hasUserJoined = true;
                }
            }
            $event = Event::findOrFail($id);

            $eventOwner = User::where('id', $event->user_id)->first()->toArray();
            return view("events.show", ["event" => $event, 'eventOwner' => $eventOwner, 'hasuserjoined' => $hasUserJoined]);
        }
    }
    public function dashboard()
    {
        $user = Auth::user();

        $events = $user->events;
        $eventasparticipant = $user->eventasparticipant;

        return view('events.dashboard', [
            'events' => $events,
            'eventasparticipant' => $eventasparticipant
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->users()->detach();
        $event->delete();
        return redirect('/dashboard')->with('msg', 'Evento Excluído com Sucesso');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $event = Event::findOrFail($id);

        if ($user->id != $event->user_id) {
            return redirect('/dashboard')->with('msg', 'Você não é responsável por esse evento');
        }

        // default items list
        $defaultItems = ['Cadeiras', 'Open Bar', 'Open Food', 'Sorteios'];
        // merge event items so any custom items also appear in the list
        $availableItems = array_values(array_unique(array_merge($defaultItems, $event->items ?? [])));
        return view('events.edit', ['event' => $event, 'availableItems' => $availableItems]);
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|integer|exists:events,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'private' => 'required|in:0,1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;

        // image upload 
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;

            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;

            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
        }

        // Process items: merge selected checkboxes with new items (comma separated)
        $items = $request->items ?? [];
        $newItemsRaw = $request->new_items ?? '';
        $newItems = array_filter(array_map('trim', explode(',', $newItemsRaw)), function ($v) {
            return $v !== '';
        });
        $allItems = array_values(array_unique(array_merge($items, $newItems)));
        $data['items'] = $this->normalizeItems($allItems);

        Event::findOrFail($request->id)->update($data);
        return redirect('/dashboard')->with('msg', 'Evento alterado com sucesso.');
    }

    /**
     * Normalize an array of item strings: trim, collapse spaces, title-case,
     * and deduplicate case-insensitively.
     *
     * @param array $items
     * @return array
     */
    private function normalizeItems(array $items): array
    {
        $normalized = [];
        $seen = [];

        foreach ($items as $item) {
            // trim and collapse multiple spaces
            $s = trim(preg_replace('/\s+/', ' ', (string) $item));
            if ($s === '') {
                continue;
            }
            // normalize case to Title Case using multibyte-safe functions
            $s = mb_convert_case(mb_strtolower($s, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
            $key = mb_strtolower($s, 'UTF-8');
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $normalized[] = $s;
            }
        }

        return array_values($normalized);
    }

    public function joinEvent($id)
    {
        $user = Auth::user();

        $user->eventAsParticipant()->attach($id);
        $event = Event::findOrFail($id);
        return redirect('/dashboard')->with('msg', 'Sua presença foi confirmada no evento' . $event->title);
    }

    public function leaveEvent($id)
    {
        $user = Auth::user();

        $user->eventAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title);
    }
}
