<?php
include "C:/xampp/htdocs/YoudmyMVC/app/Helpers/signUpSanitze.php";
class Teacher extends User
{
    private $CourseStatistics;
    private $isValidate;
    public function __construct($db)
    {
        $this->db = Database::getInstance();
    }
    public function viewCourseStatistics($id)
    {
        try {
            $query = "SELECT COUNT(*) AS totalCourses FROM Course WHERE teacher_id = :teacher_id";
            $this->db->query($query);
            $this->stmt->bindParam(':teacher_id', $id);
            $this->stmt->execute();
            $totalCourses = $this->db->resultSet()['totalCourses'];

            $query = "SELECT COUNT(*) AS totalEnrollments 
                  FROM Enrollment e 
                  JOIN Course c ON e.course_id = c.id 
                  WHERE c.teacher_id = :teacher_id";
            $this->db->query($query);
            $this->stmt->bindParam(':teacher_id', $id);
            $this->stmt->execute();
            $totalEnrollments = $this->db->resultSet()['totalEnrollments'];

            $query = "SELECT COUNT(*) AS completedEnrollments 
                  FROM Enrollment e 
                  JOIN Course c ON e.course_id = c.id 
                  WHERE c.teacher_id = :teacher_id AND e.status = 'Completed'";
            $this->db->query($query);
            $this->stmt->bindParam(':teacher_id', $id);
            $this->stmt->execute();
            $completedEnrollments = $this->db->resultSet()['completedEnrollments'];
            $this->CourseStatistics = [
                'totalCourses' => $totalCourses,
                'totalEnrollments' => $totalEnrollments,
                'completedEnrollments' => $completedEnrollments
            ];
            return [
                "status" => 1,
                "result" => $this->CourseStatistics
            ];
        } catch (PDOException $e) {
            return [
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    public function getCoursesByTeacherId($id)
    {
        try {
            $query = "SELECT * FROM Course WHERE teacher_ID = :teacher_id";
            $this->db->query($query);
            $this->stmt->bindParam(':teacher_id', $id);
            $this->stmt->execute();
            $courses = $this->db->resultSet()['completedEnrollments'];
            return [
                "status" => 1,
                "data" => $courses
            ];
        } catch (PDOException $e) {
            return [
                'status' => 0,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}
?>