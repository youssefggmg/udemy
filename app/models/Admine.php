<?php
class Admine extends User
{
    private $userlist;
    private $coursList;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    public function ActivatUser($id)
    {
        try {
            $query = "SELECT account_status from User where id = :id";
            $this->db->query($query);
            $this->db->bind(":id", $id);
            $result = $this->db->single();
            if ($result['account_status'] == "active") {
                return ["status" => 0, "error" => "User is already active"];
            } else {
                $query = "UPDATE User SET account_status = 'active' WHERE id = :id";
                $this->db->query($query);
                $this->db->bind(':id', $id);
                $executed = $this->db->execute();
                if ($executed) {
                    return ["status" => 1, "message" => "user was activated"];
                } else {
                    return ["status" => 0, "message" => "user was not activated"];
                }
            }
        } catch (PDOException $e) {
            die("error" . $e->getMessage());
        }
    }
    public function DeactivateUser($id)
    {
        try {
            $query = "SELECT account_status from User where id = :id";
            $this->db->query($query);
            $this->db->bind(":id", $id);
            $result = $this->db->single();
            if ($result['account_status'] === "inactive") {
                return ["status" => 0, "error" => "User is already inactive"];
            } else {
                $query = "UPDATE User SET account_status = 'inactive' WHERE id = :id";
                $this->db->query($query);
                $this->db->bind(":id", $id);
                $executed = $this->db->execute();
                if ($executed) {
                    return ["status" => 1, "message" => "User was deactivated"];
                } else {
                    return ["status" => 0, "message" => "User was not deactivated"];
                }
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
    public function deleteUser($id)
    {
        try {
            $query = "SELECT id FROM User WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(":id", $id);
            $result = $this->db->single();
            if (!$result) {
                return ["status" => 0, "error" => "User not found"];
            }
            $query = "DELETE FROM User WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(":id", $id);
            $executed = $this->db->execute();
            if ($executed) {
                return ["status" => 1, "message" => "User deleted successfully"];
            } else {
                return ["status" => 0, "message" => "User could not be deleted"];
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
    public function getTeachersAccount()
    {
        try {
            $query = "SELECT * FROM User WHERE user_type = 'Teacher'";
            $this->db->query($query);
            $result = $this->db->resultSet();
            return ["status" => 1, "message" => $result];
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
    public function getAllStudents()
    {
        try {
            $query = "SELECT * FROM User WHERE user_type = 'Student'";
            $this->db->query($query);
            $result = $this->db->resultSet();
            return ["status" => 1, "message" => $result];
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
    public function approveCourse($id)
    {
        try {
            $query = "SELECT status form Course where id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            if ($result["status"] == "accepted") {
                return ["status" => 0, "message" => "Course is already approved"];
            } else {
                $query = "UPDATE Course SET status = 'accepted' WHERE id = :id";
                $this->db->query($query);
                $this->db->bind(":bind", $id);
                $executed = $this->db->execute();
                if ($executed) {
                    return ["status" => 1, "message" => "Course approved successfully"];
                } else {
                    return ["status" => 0, "message" => "Course could not be approved"];
                }
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
    public function rejectCourse($id)
    {
        try {
            $query = "SELECT status FROM Course WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            if ($result["status"] == "rejected") {
                return ["status" => 0, "message" => "Course is already rejected"];
            } else {

                $this->db->query($query);
                $this->db->bind(':id' , $id);
                $executed=$this->db->execute();
                if ($executed) {
                    return ["status" => 1, "message" => "Course rejected successfully"];
                } else {
                    return ["status" => 0, "message" => "Course could not be rejected"];
                }
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }

    public function generatePlatformStatistics()
    {
        try {
            // Total number of courses
            $query = "SELECT COUNT(*) as total FROM Course";
             $this->db->query($query);
            $totalCourses = $this->db->single()["total"];
            // Total number of approved courses
            $query = "SELECT COUNT(*) as approved FROM Course WHERE status = 'approved'";
            $this->db->query($query);
            $totalApprovedCourses = $this->db->single()["approved"];
            // Total number of rejected courses
            $query = "SELECT COUNT(*) as rejected FROM Course WHERE status = 'rejected'";
            $this->db->query($query);
            $totalRejectedCourses = $this->db->single()["rejected"];
            // Total number of pending courses
            $query = "SELECT COUNT(*) as pending FROM Course WHERE status = 'pending'";
            $this->db->query($query);
            $totalPendingCourses = $this->db->single()["pending"];
            // Total number of users
            $query = "SELECT COUNT(*) as totalUsers FROM User";
            $this->db->query($query);
            $totalUsers = $this->db->single()["totalUsers"];
            // Total number of active teachers
            $query = "SELECT COUNT(*) as activeTeachers FROM User WHERE account_status = 'Active' and user_type = 'Teacher'";
            $this->db->query($query);
            $activeTeachers = $this->db->single()["activeTeachers"];
            // Total number of inactive teachers
            $query = "SELECT COUNT(*) as inactiveTeachers FROM User WHERE account_status = 'Inactive' and  user_type = 'Teacher'";
            $this->db->query($query);
            $inactiveTeachers = $this->db->single()["inactiveTeachers"];
            // Compile the statistics
            $query = "SELECT *, 
                         (SELECT COUNT(*) FROM Enrollment WHERE course_id = Course.id) as enrollment_count 
                  FROM Course
                  ORDER BY enrollment_count DESC
                  LIMIT 1";
            $this->db->query($query);
            $mostEnrolledCourse = $this->db->single();

            $platformStatistics = [
                "totalCourses" => $totalCourses,
                "totalApprovedCourses" => $totalApprovedCourses,
                "totalRejectedCourses" => $totalRejectedCourses,
                "totalPendingCourses" => $totalPendingCourses,
                "totalUsers" => $totalUsers,
                "activeTeachers" => $activeTeachers,
                "inactiveTeachers" => $inactiveTeachers,
                "mostEnrolledCourse" => $mostEnrolledCourse
            ];

            return ["status" => 1, "message" => $platformStatistics];

        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }


}
?>