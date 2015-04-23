<?php
/**
 * Created by PhpStorm.
 * User: philou
 * Date: 22.04.15
 * Time: 11:50
 */

class Student {

    public function getJobprofile($userId)
    {
        $jobprofileArray = self::getStudentJobprofile($userId);
        $jobprofileArray['availability'] = self::getAvailability($userId);

        return $jobprofileArray;
    }

    private function getStudy($userId)
    {
       // $sql = "select employmentType, workloadFrom, workloadTo, availableFrom, availableTo, commission, mobility, industry, promotion, region from messageJobprofile where studentId = $userId";
        //$response = db::query($sql, null, false, true);
        return $response[0];

    }

    private function getStudentJobprofile ($userId)
    {
        $sql = "select employmentType, workloadFrom, workloadTo, availableFrom, availableTo, commission, mobility, industry, promotion, region from studentJobprofile where studentId = $userId";
        $response = db::query($sql, null, false, true);
        return $response[0];



    }


    private function getAvailability ($userId)
    {
        $sql = "select day, morning, afternoon, evening, night from studentAvailability where studentId = $userId";
        $response = db::query($sql, null, false, true);

        $availabilities = array();

        foreach ($response as $arrayKey => $row)
        {
            $day = $row['day'];
            unset($row['day']);

            foreach ($row as $daytime => $isTrue)
            {
                $availabilities[$day][$daytime] = (bool)$isTrue;
            }
        }
        return $availabilities;
    }
}
?>