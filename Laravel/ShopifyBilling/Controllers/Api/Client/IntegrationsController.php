<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\IntegrationResource;
use App\Exceptions\ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IntegrationsController extends Controller
{
    public function index()
    {
        $integrationsCfg = config('integrations');
        $limits = [];
        foreach ($integrationsCfg as $key => $integration) {
            $limits[] = [
                'type' => $key,
                'created' => $integration['class']::query()->where('client_id', auth()->user()->client_id)->count(),
                'max_creation' => $integration['max_creation'],
            ];
        }

        return $this->apiResponse(__("Integrations!"), 200, [
            'integrations' => IntegrationResource::collection(collect(auth()->user()->client->integrations())),
            'limits' => array_values($limits),
        ]);

        //dd(IntegrationResource::collection(collect(auth()->user()->client->integrations())));
        //return  IntegrationResource::collection(collect(auth()->user()->client->integrations()));
    }

    /**
     * Store integration.
     *
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * @throws ErrorException
     */
    public function store(Request $request, $type)
    {
        $integrationModel = $this->getIntegrationModel($type);

        // Execute form request validation manually
        $validated = app($integrationModel['request'])->validated();
        $validated['client_id'] = auth()->user()->client_id;

//        $isKeyMultiple = $integrationModel['multiple'];


        $maxCreation = $integrationModel['max_creation'];

        $clientIntegrationsCount = $integrationModel['class']::query()
            ->where('client_id', auth()->user()->client_id)
            ->count();

        if ($clientIntegrationsCount >= $maxCreation) {
            return $this->apiResponse('This integration can only have '. $maxCreation .' installations!', 403);
            //return back()->withErrors(['error' => 'This integration can only have one installation!']);
        }

        // Create integration from dynamically generated integration Builder object.
        $integration = $integrationModel['class']::create($validated);

        $integrationName = $integrationModel['name'];

        return $this->apiResponse(__("$integrationName integration successfully created!"), 200, [
            'integration' => $integration,
            'key' => $type,
            'name' => $integrationName,
        ]);

//        return redirect()
//            ->route("integrations.$key.edit", $integration->id)
//            ->with('message', "$integrationName integration successfully created!");
    }


    public function show($type, $id)
    {
        $integrationModel = $this->getIntegrationModel($type);

        $integration = $integrationModel['class']::query()
            ->where('id', $id)
            ->where('client_id', auth()->user()->client_id)
            ->firstOrFail();

        return $integrationModel['resource']::make($integration);
    }

    public function update($type, Request $request, $id)
    {
        $integrationModel = $this->getIntegrationModel($type);

        // Execute form request validation manually
        $validated = app($integrationModel['request'])->validated();

        $integration = $integrationModel['class']::query()
            ->where('id', $id)
            ->where('client_id', auth()->user()->client_id)
            ->firstOrFail();

//Log::debug($validated);

        $integration->fill($validated)->save();

        return $integrationModel['resource']::make($integration)
            ->additional(['message' => __($integrationModel['name'] . ' integration successfully updated!')]);
    }

    public function destroy($type, $id)
    {
        $integrationModel = $this->getIntegrationModel($type);
        $integration = $integrationModel['class']::query()
            ->where('id', $id)
            ->where('client_id', auth()->user()->client_id)
            ->firstOrFail();

        $integration->forceDelete();

        return $this->apiResponse(__($integrationModel['name'] . ' integration successfully deleted!'));
    }

    private function getIntegrationModel($type)
    {
        $allIntegrations = config('integrations');
        if (isset($allIntegrations[$type])) {
            return $allIntegrations[$type];
        } else {
             throw new ErrorException(__("Integration do not exists"));
        }
    }

}
