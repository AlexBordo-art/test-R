<?php


namespace App\UseCases;


use App\Models\Feedback;

class FeedbackUseCases
{
    public function acceptFeedback(AcceptFeedbackData $data): Feedback
    {
        $feedback = Feedback::make();
        $feedback->title = $data->title;
        $feedback->description = $data->description;
        $feedback->datetime = $data->datetime->format('Y-m-d H:i:s');
        $feedback->service_name = $data->service_name; 
        $feedback->rating = $data->rating; 
        $feedback->save();
        $feedback->refresh();

        return $feedback;
    }
}
