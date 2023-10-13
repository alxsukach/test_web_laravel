<?php

namespace App\Models;

use App\Enums\MaritalStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Relations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Record
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property Carbon $birthday
 * @property string|null $email
 * @property array|null $phones
 * @property string $marital_status
 * @property string|null $about
 * @property boolean $agreement
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Eloquent\Collection|Media[] $files
 *
 * @package App\Models
 */
class Record extends Eloquent\Model implements HasMedia
{
    use InteractsWithMedia;

    public const FILE_COLLECTION = 'files';

    protected $table = 'records';
    public static $snakeAttributes = false;

    protected $casts = [
        'birthday' => 'date',
        'phones' => 'array',
        'marital_status' => MaritalStatusEnum::class,
        'agreement' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'birthday',
        'email',
        'phones',
        'marital_status',
        'about',
        'agreement',
    ];

    public function files(): Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'model')
            ->where('collection_name', static::FILE_COLLECTION);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::FILE_COLLECTION);
    }
}
