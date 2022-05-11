<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class TaskAddedNotification extends Notification
{
    use Queueable;

    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        $url = url('/tasks/'.$this->task->id);
        $fields = [
            '#' => $this->task->id,
            'Type' => $this->task->type,
            'Priority' => $this->task->priority,
            'Assignees' => $this->task->assignees
                ? $this->task->assignees->pluck('name')->implode(', ')
                : '-',
        ];

        return (new SlackMessage)
                    ->from('manage', ':robot_face:')
                    ->to('#manage')
                    ->content('A new task has been added to the project: *'.$this->task->project->name.'*')
                    ->attachment(function ($attachment) use ($url, $fields) {
                        $attachment->title($this->task->title, $url)
                                    ->fields($fields);
                    });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
