<?php
declare(strict_types=1);

namespace App\Domain\Image\Entity;

use App\Domain\Image\Enum\StatusEnum;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $imageId
 * @property StatusEnum $status
 */
class Image extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%image}}';
    }

    public function rules(): array
    {
        return [
            [['imageId', 'status'], 'required'],
        ];
    }

}