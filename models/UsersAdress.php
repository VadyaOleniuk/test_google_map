<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_adress".
 *
 * @property integer $id
 * @property integer $city_id
 * @property integer $area_id
 * @property string $name
 * @property string $street
 * @property string $house
 * @property string $additional_information
 * @property string $lat
 * @property string $lng
 *
 * @property Area $area
 * @property City $city
 */
class UsersAdress extends \yii\db\ActiveRecord
{
    private $key = '';
    private $google = '';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_adress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'area_id', 'name'], 'required'],
            [['city_id', 'area_id'], 'integer'],
            [['additional_information', 'lng', 'lat'], 'string'],
            [['name', 'house'], 'string', 'max' => 255],
            [['street'], 'string', 'max' => 512],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'area_id' => 'Area ID',
            'name' => 'Name',
            'street' => 'Street',
            'house' => 'House',
            'additional_information' => 'Additional Information',
            'lng' => 'lng',
            'lat' => 'lat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }
    
    public function save($runValidation = true, $attributeNames = null) {
         if( $curl = curl_init() ) {
            $city = $this->city;
            $city = str_replace(" ", "+", $city->name);
            $area = $this->area;
            $area = str_replace(" ", "+", $area->name);
            $param = $area.'+'.$city;
            if($this->street){
                $param .= '+'. str_replace(" ", "+",$this->street);
            }
            if($this->house){
                $param .= '+'.str_replace(" ", "+", $this->house);
            }            
            curl_setopt($curl, CURLOPT_URL, $this->google.$param.$this->key);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            $out = json_decode($out);
            curl_close($curl);
        }
        if(isset($out->results[0]->geometry->location->lat)&&isset($out->results[0]->geometry->location->lng)){
            $this->lat =''. $out->results[0]->geometry->location->lat;
            $this->lng =''. $out->results[0]->geometry->location->lng;
            
	    return parent::save($runValidation, $attributeNames);
        }else{
            return false;
        }
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
