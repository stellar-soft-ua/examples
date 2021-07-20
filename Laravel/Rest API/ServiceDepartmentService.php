<?php

namespace App\Services\Service;

use App\Models\Role;
use App\Models\Service\ServiceTask;
use App\Models\Service\ServiceUser;
use App\Models\Service\ServiceVehicle;
use App\Models\Store;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Services\Exceptions\ServiceException;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

class ServiceDepartmentService
{
    public function getServiceTasks(Store $store, User $user, $my = null)
    {
        $user = $this->getServiceUser($store, $user->id);

        if (! $user) {
            throw new ServiceException('User not exist');
        }

        $builder = Vehicle::select([
            'service_tasks.id as id',
            'service_tasks.vehicle_id',
            'service_tasks.job_id',
            'service_tasks.description',
            'service_tasks.status',
            'service_tasks.duration',
            'service_tasks.responsible_id',
        ])->where('store_id', $store->id)
            ->join('service_tasks', 'service_tasks.vehicle_id', '=', 'vehicles.id')

        ->when($my, static function ($query) use ($user) {
            $query->where('service_tasks.responsible_id', $user->id);
        });

        return $builder->paginate(ServiceTask::PAGINATION);
    }

    /**
     * @param  ServiceVehicle $vehicle
     * @return Collection
     */
    public function getAssignedUsers(ServiceVehicle $vehicle): Collection
    {
        return ServiceUser::distinct()
            ->select('users.*')
            ->join('service_tasks', static function (JoinClause $join) use ($vehicle) {
                $join->on('service_tasks.responsible_id', 'users.id')
                    ->where('service_tasks.vehicle_id', $vehicle->id);
            })
            ->get();
    }

    /**
     * @param  Vehicle $vehicle
     * @return Vehicle
     */
    public function getVehicle(Vehicle $vehicle): Vehicle
    {
        return $vehicle->load([
            'states.jobs.tasks',
        ]);
    }

    /**
     * @return Collection
     */
    public function getServiceStaff(): Collection
    {
        return User::role(Role::SERVICE_ROLES)
            ->with('roles')
            ->get();
    }

    /**
     * @param  Store            $store
     * @param  ServiceTask      $task
     * @param  int              $user_id
     * @return ServiceTask
     * @throws ServiceException
     */
    public function serviceTaskAssign(Store $store, ServiceTask $task, int $user_id): ServiceTask
    {
        $user = $this->getServiceUser($store, $user_id);

        if (! $user) {
            throw new ServiceException('User not exist');
        }

        $task->responsible()->associate($user);
        $task->save();

        return $task;
    }

    /**
     * @param  Store     $store
     * @param  int       $user_id
     * @return User|null
     */
    protected function getServiceUser(Store $store, int $user_id): ?User
    {
        /**
         * @var User $user
         */
        $user = User::role(Role::SERVICE_ROLES)
            ->whereHas('department', static function ($query) use ($store) {
                $query->where('store_id', $store->id);
            })->find($user_id);

        return $user;
    }

    /**
     * @param  Collection $collection
     * @param  string     $status
     * @return bool
     */
    protected function someStatusIs(Collection $collection, string $status): bool
    {
        return $collection->some('status', $status);
    }

    /**
     * @param  Collection $collection
     * @param  string     $status
     * @return bool
     */
    protected function everyStatusIs(Collection $collection, string $status): bool
    {
        return $collection->every('status', $status);
    }
}
