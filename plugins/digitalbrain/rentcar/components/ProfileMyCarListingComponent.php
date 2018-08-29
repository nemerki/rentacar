<?php namespace DigitalBrain\RentCar\Components;

use Cms\Classes\ComponentBase;
use Auth;
use DigitalBrain\RentCar\Models\Car;

class ProfileMyCarListingComponent extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'ProfileMyCarListing',
            'description' => 'Profile My Car Listing Page Component'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {

        $this->page['cars'] = $this->listCar();


    }

    public function listCar()
    {
        $user_id = Auth::getUser()->id;

        return Car::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(12);
    }

    public function onDelete()
    {
        $id = post('id');

        $car = Car::find($id);
        $car->delete();
        $this->page['partialsRecords'] = $this->listCar();

    }

    public function onUnpublishCar()
    {
        $id = post('id');

        $car = Car::find($id);
        $car->update(['is_published' => '0']);
        $this->page['partialsRecords'] = $this->listCar();

    }

    public function onPublishCar()
    {
        $id = post('id');

        $car = Car::find($id);
        $car->update(['is_published' => '1']);
        $this->page['partialsRecords'] = $this->listCar();

    }

    public function onPaginate()
    {

        $user_id = Auth::getUser()->id;

        $model = Car::where('user_id', $user_id)->orderBy('created_at', 'desc');

        $perPage = post('perPage');
        $pageNumber = $perPage;


        $partialsRecords = $model->paginate(12, $pageNumber);

        $this->records = $this->page['partialsRecords'] = $partialsRecords;


    }
}
