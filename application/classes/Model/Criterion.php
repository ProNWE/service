<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Model_Criterion
 * CRUD
 */
class Model_Criterion extends Model {

    public $id;
    public $event;
    public $name;
    public $description;
    public $minScore;
    public $maxScore;

    public function __construct($id = null) {

        if ( !empty($id) ) {
            $this->get_($id);
        }

    }

    private function fill_by_row($db_selection) {

        if (empty($db_selection['id'])) return $this;

        foreach ($db_selection as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $this->$fieldname = $value;
        }

        return $this;

    }

    private function get_($id) {

        $select = Dao_Criterions::select()
            ->where('id', '=', $id)
            ->limit(1)
            ->cached(Date::MINUTE * 5, $id)
            ->execute();

        $this->fill_by_row($select);

        return $this;

    }


    /**
     * Saves Criterion to Database
     */
    public function save()
    {

        $this->dt_create = Date::formatted_time('now', 'Y-m-d');

        $insert = Dao_Criterions::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $insert->clearcache('event:' . $this->event);
        $insert->clearcache($this->id);
        
        $result = $insert->execute();

        return $this->get_($result);

    }


    /**
     * Updates Criterion data in database
     *
     * @return Model_Criterion
     */
    public function update()
    {

        $insert = Dao_Criterions::update();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $insert->clearcache('event:' . $this->event);
        $insert->clearcache($this->id);
        $insert->where('id', '=', $this->id);

        $insert->execute();

        return $this->get_($this->id);

    }


    /**
     * Delete Criterion data in database
     *
     * @return Model_Criterion
     */
    public function delete() {
        $delete = Dao_Criterions::delete()
            ->where('id', '=', $this->id)
            ->clearcache('event:' . $this->event)
            ->clearcache($this->id)
            ->execute();
        return $delete;
    }

}