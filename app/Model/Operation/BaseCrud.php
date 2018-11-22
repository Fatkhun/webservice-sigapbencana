<?php

namespace App\Model\Operation;


use App\Helpers\GlobalFunc;
use App\Helpers\GlobalVar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BaseCrud
{
    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function isExistById($id) {
        $data = $this->model->find($id);

        if (!$data)
            return false;
        return true;
    }

    public function findAll() {
        $data = $this->model->all();

        if (!$data) {
            return GlobalVar::$DATANOTFOUND;
        }
        return $data;
    }

    public function findById($id) {
        $data = $this->model->find($id);

        if (!$data) {
            return GlobalVar::$DATANOTFOUND;
        }
        return $data;
    }

    public function findWhere($conditions = []) {
        $data = $this->model->where($conditions)->get();

        if (!$data) {
            return GlobalVar::$DATANOTFOUND;
        }
        return $data;
    }

    public function findWith($with = []) {
        $data = $this->model->with($with)->get();

        if (!$data) {
            return GlobalVar::$DATANOTFOUND;
        }
        return $data;
    }


    public function findWithWhere($with = [], $where = []) {
        $data = $this->model->with($with)->where($where)->get();

        if (!$data) {
            return GlobalVar::$DATANOTFOUND;
        }
        return $data;
    }

    public function create($input = [], $roles = []) {
        $validated  = GlobalFunc::validates($input, $roles);
        if (!$validated)
            return GlobalVar::$VALIDATE_FAILED;

        $input['created_at'] = Carbon::now()->toDateTimeString();
        $input['updated_at'] = Carbon::now()->toDateTimeString();

        $process    = $this->model->insert($input);
        if ($process) {
            return [
                'success'   => true,
                'message'   => GlobalVar::$SAVE_SUCCESS_MESSAGE
            ];
        } else {
            return [
                'success'   => false,
                'message'   => GlobalVar::$SAVE_FAILED_MESSAGE
            ];
        }
    }

    public function createGetId($input = [], $roles = []) {
        $validated  = GlobalFunc::validates($input, $roles);
        if (!$validated)
            return GlobalVar::$VALIDATE_FAILED;

        $input['created_at'] = Carbon::now()->toDateTimeString();
        $input['updated_at'] = Carbon::now()->toDateTimeString();

        $process    = $this->model->insertGetId($input);
        if ($process) {
            return [
                'success'   => true,
                'message'   => GlobalVar::$SAVE_SUCCESS_MESSAGE,
                'data'      => [
                    'id'    => $process
                ]
            ];
        } else {
            return [
                'success'   => false,
                'message'   => GlobalVar::$SAVE_FAILED_MESSAGE
            ];
        }
    }

    public function update($input, $roles, $id) {
        $validated  = GlobalFunc::validates($input, $roles);
        if (!$validated)
            return GlobalVar::$VALIDATE_FAILED;

        $input['updated_at'] = Carbon::now()->toDateTimeString();

        if ($this->isExistById($id)) {
            $process = $this->model->where('id', $id)->update($input);
            if ($process) {
                return [
                    'success' => true,
                    'message' => GlobalVar::$UPDATE_SUCCESS_MESSAGE
                ];
            } else {
                return [
                    'success' => false,
                    'message' => GlobalVar::$UPDATE_FAILED_MESSAGE
                ];
            }
        } else {
            return GlobalVar::$DATANOTFOUND;
        }
    }

    public function delete($id) {
        if ($this->isExistById($id)) {
            $process    = $this->model->where('id', $id)->delete();
            if ($process) {
                return [
                    'success'   => true,
                    'message'   => GlobalVar::$DELETE_SUCCESS_MESSAGE
                ];
            } else {
                return [
                    'success'   => false,
                    'message'   => GlobalVar::$DELETE_FAILED_MESSAGE
                ];
            }
        } else {
            return GlobalVar::$DATANOTFOUND;
        }
    }
}