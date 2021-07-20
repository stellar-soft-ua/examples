<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceTaskAssignRequest;
use App\Http\Resources\Services\ServiceJobTasksResource;
use App\Http\Resources\Services\ServiceStaffResource;
use App\Http\Resources\Services\ServiceTasksCollectionResource;
use App\Http\Resources\Services\ServiceVehicleResource;
use App\Models\Service\ServiceTask;
use App\Models\Store;
use App\Models\User;
use App\Models\Vehicle\Vehicle;
use App\Services\Exceptions\ServiceException;
use App\Services\Service\ServiceDepartmentService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    /**
     * @param  Store                                   $store
     * @param  User                                    $user
     * @param  ServiceDepartmentService                $service
     * @return ServiceTasksCollectionResource|Response
     */
    public function getTasks(Store $store, User $user, ServiceDepartmentService $service)
    {
        try {
            return new ServiceTasksCollectionResource($service->getServiceTasks($store, $user));
        } catch (ServiceException $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * @param  Store                                   $store
     * @param  User                                    $user
     * @param  ServiceDepartmentService                $service
     * @return ServiceTasksCollectionResource|Response
     */
    public function getMyTasks(Store $store, User $user, ServiceDepartmentService $service)
    {
        try {
            return new ServiceTasksCollectionResource($service->getServiceTasks($store, $user, true));
        } catch (ServiceException $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }

    /**
     * @param  Store                    $store
     * @param  Vehicle                  $vehicle
     * @param  ServiceDepartmentService $service
     * @return ServiceVehicleResource
     */
    public function getVehicle(Store $store, Vehicle $vehicle, ServiceDepartmentService $service): ServiceVehicleResource
    {
        return new ServiceVehicleResource($service->getVehicle($vehicle));
    }

    /**
     * @param  ServiceDepartmentService    $service
     * @return AnonymousResourceCollection
     */
    public function getStaff(ServiceDepartmentService $service): AnonymousResourceCollection
    {
        return ServiceStaffResource::collection($service->getServiceStaff());
    }

    /**
     * @param  Store                            $store
     * @param  ServiceTask                      $task
     * @param  ServiceTaskAssignRequest         $request
     * @param  ServiceDepartmentService         $service
     * @return ServiceJobTasksResource|Response
     */
    public function taskAssign(
        Store $store,
        Vehicle $vehicle,
        ServiceTask $task,
        ServiceTaskAssignRequest $request,
        ServiceDepartmentService $service
    ) {
        try {
            $assignedTask = $service->serviceTaskAssign($store, $task, $request->get('user_id'));

            return new ServiceJobTasksResource($assignedTask);
        } catch (ServiceException $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
