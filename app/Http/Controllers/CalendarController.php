<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    // 1. Tampilkan halaman kalender
    public function index()
    {
        return view('calendar.index');
    }

    // 2. Ambil data event untuk FullCalendar
    public function getEvents()
    {
        // Ambil semua event, FullCalendar butuh title, start, dan end
        $events = Event::all(['id', 'title', 'start', 'end']);

        // FullCalendar bisa langsung memproses format ini
        return response()->json($events);
    }

    // 3. Simpan event baru dari permintaan AJAX (klik pada kalender)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            // 'description' => 'nullable|string', // Opsional, bisa ditambahkan
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end, // Bisa null jika tidak ada end time
            'description' => $request->description ?? null,
        ]);

        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        // Validasi, pastikan event memiliki kolom 'start' dan 'title'
        $request->validate([
            'title' => 'nullable|string|max:255',
            'start' => 'nullable|date',
        ]);

        // Update data event dengan data yang masuk (termasuk start dan end jika dipindahkan)
        $event->update($request->only('title', 'start', 'end'));

        return response()->json(['message' => 'Event berhasil diubah!'], 200);
    }

    // BARU: Metode untuk menghapus event
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event berhasil dihapus!'], 204);
    }
}