<?php

namespace Modules\Countries\Services;


use App\Services\Responses\ResponseError;
use App\Services\Responses\ResponseSuccess;
use Modules\Countries\Repositories\CountriesRepositories;
use Modules\Countries\Dto\CountriesDto;


class CountriesServices
{
    protected ?string $classPath;
    public function __construct(public CountriesRepositories $countriesRepositories)
    {
        $this->classPath = __DIR__ . '/' . class_basename(__CLASS__) . '.php';
    }

    public function index($params): array
    {
        $countries= $this->countriesRepositories->getAllCountries($params);
        return ['data' => [
            'countries' => $countries,
        ]];
    }


    public function store(CountriesDto $countriesDto): ResponseError|ResponseSuccess
    {
        // STORE COUNTRIES
        $country = $this->countriesRepositories->storeCountry($countriesDto);
        if (!$country) {
            return new ResponseError('storeCountry($countriesDto)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',['id'=>$country->id]);
    }

    public function show($id): array
    {
        $country = $this->countriesRepositories->getCountryById($id);
        return ['data' => [
            'country' => $country,
        ]];
    }

    public function edit( int $id): array
    {
        $country = $this->countriesRepositories->getCountryById($id);

        return ['data' => [
            'country' => $country,
        ]];
    }
    public function update(CountriesDto $countriesDto): ResponseSuccess|ResponseError
    {
        $id = $countriesDto->id;

        // CHECK IF PROJECT EXIST ///////////////////////////////////////////////
        $country = $this->countriesRepositories->getCountryById($id);

        if (!$country) {
            return new ResponseError('method: getCountryById($id)',  $this->classPath,[]);
        }
        // UPDATE COUNTRIES
        $country = $this->countriesRepositories->updateCountry($id, $countriesDto);
        if (!$country) {
            return new ResponseError('$id, $countriesDto)',  $this->classPath,[]);
        }
        return new ResponseSuccess('','',[]);
    }
    public function deleteCountry($id): ResponseSuccess|ResponseError
    {


        $return= $this->countriesRepositories->checkIfCountryExistInRecords($id);
        if ($return) {
            return new ResponseError('checkIfCountryExistInRecords($id)', $this->classPath, ['error_message' => __('countries.CountriesServices.error_delete_country')]);
        }

        $return= $this->countriesRepositories->checkIfCountryExistInUsers($id);
        if ($return) {
            return new ResponseError('checkIfCountryExistInUsers($id)', $this->classPath, ['error_message' => __('countries.CountriesServices.delete_no_attached_users')]);
        }

        $return= $this->countriesRepositories->deleteCountry($id);
        if (!$return) {
            return new ResponseError('deleteCountry($id)',  $this->classPath, ['error_message' => __('countries.CountriesServices.deleted_error')]);
        }

        return new ResponseSuccess('deleteCountry($id)',$this->classPath,['success_message' => __('countries.CountriesServices.deleted')]);
    }
}
