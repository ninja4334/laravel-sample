<?php

namespace App\Providers;

use App\Repositories\Criteria\ActiveCriteria;
use App\Repositories\Criteria\LatestCriteria;
use App\Repositories\Criteria\SystemCriteria;
use App\Repositories\Criteria\WithTrashedCriteria;
use Freevital\Repository\Eloquent\BaseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $contractsNamespace = 'App\Repositories\Contracts';

    /**
     * @var string
     */
    private $classesNamespace = 'App\Repositories\Eloquent';

    /**
     * @var array
     */
    private $repositories = [
        'AppRepository',
        'AppActivityRepository',
        'AppCertificateRepository',
        'AppChecklistRepository',
        'AppDocumentRepository',
        'AppNoteRepository',
        'AppNotificationRepository',
        'AppRequirementRepository',
        'AppSubmissionNoteRepository',
        'AppSubmissionRepository',
        'AppStatusRepository',
        'AppTypeRepository',
        'BoardProfessionRepository',
        'BoardRepository',
        'MediaRepository',
        'PageRepository',
        'PermissionRepository',
        'RoleRepository',
        'SettingsRepository',
        'StateRepository',
        'SubmissionDocumentRepository',
        'SubmissionNoteRepository',
        'SubmissionRepository',
        'SubmissionRequirementRepository',
        'SubmissionSearchHistoryRepository',
        'TransactionRepository',
        'UserRepository',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        BaseRepository::macro('active', function (BaseRepository $repository) {
            $repository->pushCriteria(new ActiveCriteria());
        });
        BaseRepository::macro('system', function (BaseRepository $repository, $is_system = false) {
            $repository->pushCriteria(new SystemCriteria($is_system[0]));
        });
        BaseRepository::macro('withTrashed', function (BaseRepository $repository) {
            $repository->pushCriteria(new WithTrashedCriteria());
        });
        BaseRepository::macro('latest', function (BaseRepository $repository) {
            $repository->pushCriteria(new LatestCriteria());
        });
    }

    /**
     * Bind the repositories.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $class) {
            $this->app->bind(
                $this->contractsNamespace . '\\' . $class . 'Contract',
                $this->classesNamespace . '\\' . $class
            );
        }

        $this->app->bind(
            'App\Repositories\Contracts\Apps\CEActivityRepositoryContract',
            'App\Repositories\Eloquent\Apps\CEActivityRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\Apps\AppRepositoryContract',
            'App\Repositories\Eloquent\Apps\AppRepository'
        );
    }
}
