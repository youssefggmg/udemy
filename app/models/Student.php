<?php
include "../models/user.php";
class Student extends User
{
    public function __construct()
    {
        $this->db= Database::getInstance();
    }
    public function __get($name){
            return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }


    public function enrollInCourse($courseId ,$student_id): array
    {
        try {
            $query = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
            $this->db->query($query);
            $this->db->bind(':student_id', $student_id);
            $this->db->bind(':course_id', $courseId);
            $this->db->execute();
            return ['status' => 1, 'message' => 'Successfully enrolled in the course.'];
        } catch (PDOException $e) {
            return ['status' => 0, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function viewMyCourses($id): array
    {
        try {
            $query = "SELECT c.id, c.title, c.description, c.content_type
                        FROM Course c 
                        JOIN Enrollment e ON c.id = e.course_id 
                        WHERE e.student_id = :student_id";
            $this->db->query($query);
            $this->db->bind(':student_id', $id);
            $this->db->execute();
            $courses = $this->db->resultSet();
            return ['status' => 1, 'data' => $courses];
        } catch (PDOException $e) {
            return ['status' => 0, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>