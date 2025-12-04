<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contactObject extends Model
{
    public $table = 'contacts_for_objects';

    protected $fillable = ['model_id'];

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function relation()
    {
        return $this->hasOne(Relation::class, 'id', 'model_id');
    }

    public function models()
    {
        return $this->hasOne(Relation::class, 'id', 'model_id');
    }

    public function getRelatedToAttribute()
    {

        switch ($this->model) {
            case 'relation':
                return Relation::whereId($this->model_id)->first();
                break;
            // case 'project':
            //     return Project::whereId($this->model_id)->first();
            //     break;
            // case 'location':
            //     return ObjectLocation::whereId($this->model_id)->first();
            //     break;
            // case 'object':
            //     return ObjectsAsset::whereId($this->model_id)->first();
            //     break;
            // case 'contactperson':
            //     return Contact::whereId($this->model_id)->first();
            //     break;
            default:
                //code block
        }

    }

}
