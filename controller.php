<?php namespace timetable;
class Controller
{

    protected $dataForView = array();

    /**
     * @var Model $model
     */
    private static $model;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        if (self::$model == null)
            self::$model = new Model();
    }

    /**
     * @param array $input
     */
    public function handleInput($input)
    {
        $lessons = self::$model->getLessons();

        $this->sortByLesson($lessons);
        $this->compactDuplicate($lessons);

        $lessonsByDate = array();
        /** @var Lesson $lesson */
        foreach ($lessons as $lesson)
            $lessonsByDate[$this->getDayDescription($lesson->getDate())][] = $lesson;

        $this->dataForView['lessons'] = $lessonsByDate;

        $this->display("main");

    }

    /**
     * @param string $day
     * @return string
     */
    public function getDayDescription($day)
    {
        $day = explode("den ", $day)[1]; //dd.mm.yyy

        $dateTime = \DateTime::createFromFormat("d.m.Y", $day);

        $day = $dateTime->format("D. d.m.y");

        return $day;
    }

    /**
     * @param string $template Template to be displayed
     */
    public function display($template)
    {
        ChromePhp::info("Displaying $template with data " . json_encode($this->dataForView));
        $view = View::getInstance();
        $view->setDataForView($this->dataForView);
        $view->loadTemplate($template);
    }

    /**
     * @param $array
     */
    public function sortByLesson(&$array)
    {

        usort($array, function ($a, $b)
        {
            /**
             * @var Lesson $a
             * @var Lesson $b
             */
            return strcmp($a->getHour(), $b->getHour());
        });

    }

    /**
     * @param $array
     */
    public function compactDuplicate(&$array)
    {

        $removed = array();

        /**
         * @var Lesson $a
         * @var Lesson $b
         */
        foreach ($array as $a)
        {
            foreach ($array as $b)
            {
                if(strpos($a->getHour(), "-") !== false || strpos($b->getHour(), "-") !== false)
                    continue;

                if($a->isConnectedClass($b))
                {
                    $a->setHour($a->getHour() . "-" . $b->getHour());
                    $this->unsetValue($array, $b);
                }
            }
        }


    }

    /**
     * Removes a value from an array
     * @param array $array value should be removed from
     * @param mixed $value value to be removed
     */
    public function unsetValue(&$array, $value)
    {
        if(($key = array_search($value, $array)) !== false) {
            unset($array[$key]);
        }
    }

}

?>