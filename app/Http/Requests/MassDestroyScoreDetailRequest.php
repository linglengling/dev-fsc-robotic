<?php

namespace App\Http\Requests;

use App\Models\ScoreDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyScoreDetailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('score_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:score_details,id',
        ];
    }
}
