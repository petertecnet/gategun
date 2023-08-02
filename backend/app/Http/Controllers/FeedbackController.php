<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Exibe o formulário para fornecer feedback e avaliação
    public function showFeedbackForm($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('feedback.form', compact('event'));
    }

    // Armazena o feedback e a avaliação fornecidos pelo participante
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Feedback::create([
            'event_id' => $request->input('event_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('events.show', $request->input('event_id'))->with('success', 'Feedback e avaliação enviados com sucesso!');
    }

    // Exibe os feedbacks e avaliações do evento
    public function showEventFeedbacks($eventId)
    {
        $event = Event::findOrFail($eventId);
        $feedbacks = Feedback::where('event_id', $eventId)->get();
        return view('feedback.show', compact('event', 'feedbacks'));
    }
}
