<?php
namespace App\Filament\Resources\ObjectLocationResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateObjectLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                    => 'string',
            'image'                   => 'string',
            'zipcode'                 => 'required||string',
            'place'                   => 'required||string',
            'address'                 => 'required||string',
            'housenumber'             => 'required|string',
            'slug'                    => 'string',
            'complexnumber'           => 'string',
            'management_id'           => 'integer',
            'customer_id'             => 'integer',
            'building_type_id'        => 'integer',
            'building_acces_type_id'  => 'integer',
            'access_type_id'          => 'integer',
            'remark'                  => 'string',
            'access_code'             => 'string',
            'gps_lat'                 => 'string',
            'gps_lon'                 => 'string',
            'levels'                  => 'string',
            'surface'                 => 'string',
            'access_contact'          => 'string',
            'location_key_lock'       => 'string',
            'province'                => 'string',
            'municipality'            => 'string',
            'building_type'           => 'string',
            'construction_year'       => 'string',
            'building_access_type_id' => 'string',
            'company_id'              => 'required|integer',
        ];
    }
}
