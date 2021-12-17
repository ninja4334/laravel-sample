<?php

namespace App\Jobs;

use App\Mail\ToUserMail;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Criteria\UserCriteria;
use App\Repositories\Criteria\UserNotificationCriteria;
use App\Repositories\Criteria\WithAppNotificationRelationsCriteria;
use App\Repositories\Eloquent\AppNotificationRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendAppNotification
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @var AppNotificationRepository
     */
    protected $notificationRepository;

    /**
     * @var Carbon
     */
    protected $currentDate;

    /**
     * Execute the job.
     *
     * @param UserRepositoryContract    $userRepository
     * @param AppNotificationRepository $notificationRepository
     *
     * @return void
     */
    public function handle(
        UserRepositoryContract $userRepository,
        AppNotificationRepository $notificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;

        $notifications = $this->notificationRepository->all();
        $notifications = $notifications->groupBy('type');
        $this->currentDate = Carbon::now();

        foreach ($notifications as $key => $value) {
            $handler = 'send' . ucfirst($key) . 'Notifications';

            $this->{$handler}($value);
        }
    }

    /**
     * Send one time notifications.
     *
     * @param $notifications
     *
     * @return void
     */
    private function sendOnceNotifications($notifications)
    {
        $typeIds = $notifications->pluck('type_id')->toArray();
        $users = $this->getUsersByNotifications($typeIds);

        foreach ($notifications as $notification) {
            if (!$notification->sent_at && $notification->date->isToday()) {
                $this->sendNotification($notification, $users);
            }
        }
    }

    /**
     * Send yearly notifications.
     *
     * @param $notifications
     *
     * @return void
     */
    private function sendYearlyNotifications($notifications)
    {
        $typeIds = $notifications->pluck('type_id')->toArray();
        $users = $this->getUsersByNotifications($typeIds);

        foreach ($notifications as $notification) {
            if ($notification->isSentToday()) {
                return;
            }

            $date = $notification->sent_at ?? $notification->date;

            if ($date->format('m-d') == $this->currentDate->format('m-d')) {
                $this->sendNotification($notification, $users);
            }
        }
    }

    /**
     * Send monthly notifications.
     *
     * @param $notifications
     *
     * @return void
     */
    private function sendMonthlyNotifications($notifications)
    {
        $typeIds = $notifications->pluck('type_id')->toArray();
        $users = $this->getUsersByNotifications($typeIds);

        foreach ($notifications as $notification) {
            if ($notification->isSentToday()) {
                return;
            }

            $date = $notification->sent_at ?? $notification->date;

            if ($date->day == $this->currentDate->day) {
                $this->sendNotification($notification, $users);
            }
        }
    }

    /**
     * Send daily notifications.
     *
     * @param $notifications
     *
     * @return void
     */
    private function sendDailyNotifications($notifications)
    {
        $typeIds = $notifications->pluck('type_id')->toArray();
        $users = $this->getUsersByNotifications($typeIds);

        foreach ($notifications as $notification) {
            if ($notification->isSentToday()) {
                return;
            }

            $this->sendNotification($notification, $users);
        }
    }

    /**
     * Send notification to users.
     *
     * @param $notification
     * @param $users
     *
     * @return void
     */
    private function sendNotification($notification, $users)
    {
        $notification->sent_at = Carbon::now();
        $notification->save();

        foreach ($users as $user) {
            $mail = new ToUserMail($notification->title, $notification->body);

            Mail::to($user->email)->queue($mail);
        }
    }

    /**
     * Get the users by notifications.
     *
     * @param array $type_ids
     *
     * @return mixed
     */
    private function getUsersByNotifications(array $type_ids)
    {
        return $this->userRepository
            ->pushCriteria(new UserNotificationCriteria(compact('type_ids')))
            ->all();
    }
}
