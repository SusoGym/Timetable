<?php namespace timetable;
class Model
{

    public static $BASE_URL = "http://www.suso.schulen.konstanz.de/";
    public static $SUB_DIR = "_VPlanSuso/";

    /**
     * @return array(Lesson) allLessons
     */
    public function getLessons()
    {
        $class = $this->getClass();
        $subjects = $this->getAllSubjects();

        if ($subjects == null || sizeof($subjects) == 0)
            return array();

        $lessons = array();

        $url = self::$BASE_URL . self::$SUB_DIR . "?sess=$class:";
        foreach ($subjects as $subject)
        {
            $url .= "$subject;";
        }


        $data = explode("<br>", $this->fetchURL($url));
        array_shift($data);
        ChromePhp::info(json_encode($data));

        foreach ($data as $cancelledLesson)
        {
            $lessonData = explode(";", $cancelledLesson);


            if (sizeof($lessonData) != 9)
                continue;
            //if(strpos($lessonData[1], '-') === false)
            $lessons[] = new Lesson($lessonData[1], $lessonData[0], $lessonData[2], $lessonData[3], $lessonData[4], $lessonData[5], $lessonData[6], $lessonData[7], $lessonData[8]);
            /*   else
               {
                   $lessons[] = new Lesson(explode('-', $lessonData[1])[0], $lessonData[0], $lessonData[2], $lessonData[3], $lessonData[4], $lessonData[5], $lessonData[6], $lessonData[7], $lessonData[8]);
                   $lessons[] = new Lesson(explode('-', $lessonData[1])[1], $lessonData[0], $lessonData[2], $lessonData[3], $lessonData[4], $lessonData[5], $lessonData[6], $lessonData[7], $lessonData[8]);
               }*/
        }

        return $lessons;
    }

    /**
     * @param $url string
     * @return string result
     * @throws \ErrorException if fetching was not successfully completed
     */
    public function fetchURL($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($ch);

        if (curl_errno($ch))
            throw new \ErrorException(curl_error($ch));

        return $result;
    }

    /**
     * @return array(String) subjects
     */
    public function getAllSubjects()
    {
        return array("M3", "EN4", "PH", "GK", "DE3", "CH1", "GE3", "INF", "ETH", "SEM2", "MU1");
        //return array("SP", "EN2", "EN4", "DE1", "M2", "SP", "M1" /* ... */);
    }

    /**
     * @return string class
     */
    public function getClass()
    {
        return "K1";
    }

}

class Lesson
{
    /**
     * @var string $hour
     */
    private $hour;

    /**
     * @var string $date
     */
    private $date;

    /**
     * @var string $subSubject
     */
    private $subSubject;

    /**
     * @var string $subTeacher
     */
    private $subTeacher;

    /**
     * @var string $subRoom
     */
    private $subRoom;

    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $cancelledSubject
     */
    private $cancelledSubject;

    /**
     * @var string $cancelledTeacher
     */
    private $cancelledTeacher;

    /**
     * @var string $comment
     */
    private $comment;


    public function __construct($hour, $date, $subSubject, $subTeacher, $subRoom, $class, $cancelledSubject, $cancelledTeacher, $comment)
    {
        $this->hour = $hour;
        $this->date = $date;
        $this->subSubject = $subSubject;
        $this->subTeacher = $subTeacher;
        $this->subRoom = $subRoom;
        $this->class = $class;
        $this->cancelledSubject = $cancelledSubject;
        $this->cancelledTeacher = $cancelledTeacher;
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getCancelledSubject()
    {
        return $this->cancelledSubject;
    }

    /**
     * @return string
     */
    public function getCancelledTeacher()
    {
        return $this->cancelledTeacher;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @return string
     */
    public function getSubRoom()
    {
        return $this->subRoom;
    }

    /**
     * @return string
     */
    public function getSubSubject()
    {
        return $this->subSubject;
    }

    /**
     * @return string
     */
    public function getSubTeacher()
    {
        return $this->subTeacher;
    }

    /**
     * @param string $cancelledSubject
     */
    public function setCancelledSubject($cancelledSubject)
    {
        $this->cancelledSubject = $cancelledSubject;
    }

    /**
     * @param string $cancelledTeacher
     */
    public function setCancelledTeacher($cancelledTeacher)
    {
        $this->cancelledTeacher = $cancelledTeacher;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param string $hour
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    /**
     * @param string $subRoom
     */
    public function setSubRoom($subRoom)
    {
        $this->subRoom = $subRoom;
    }

    /**
     * @param string $subSubject
     */
    public function setSubSubject($subSubject)
    {
        $this->subSubject = $subSubject;
    }

    /**
     * @param string $subTeacher
     */
    public function setSubTeacher($subTeacher)
    {
        $this->subTeacher = $subTeacher;
    }

    /**
     * @return array all data of this class
     */
    public function getData()
    {
        return ["hour"             => $this->hour,
                "date"             => $this->date,
                "subSubject"       => $this->subSubject,
                "subTeacher"       => $this->subTeacher,
                "subRoom"          => $this->subRoom,
                "class"            => $this->class,
                "cancelledSubject" => $this->cancelledSubject,
                "cancelledTeacher" => $this->cancelledTeacher,
                "comment"          => $this->comment];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->getData());
    }

    /**
     * @param Lesson $otherLesson
     * @return bool has same content as other class
     */
    public function isConnectedClass($otherLesson)
    {
        if (strpos($otherLesson->getHour(), "-") !== false || strpos($this->getHour(), "-") !== false)
            return false;

        if (($otherLesson->getHour() != intval($this->getHour()) + 1) && ($otherLesson->getHour() != intval($this->getHour()) - 1))
            return false;

        $data1 = $otherLesson->getData();
        $data2 = $this->getData();

        unset($data1['hour']);
        unset($data2['hour']);

        return json_encode($data1) === json_encode($data2);
    }

}