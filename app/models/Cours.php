<?php
class Cours
{
    private $id;
    private $title;
    private $description;
    private $content;
    private $video;
    private $status;
    private $contentType;
    private $creation_date;
    private $db;

    public function __construct(
        $id = "",
        $title = "",
        $description = "",
        $content = "",
        $video = "",
        $status = "",
        $contentType = "",
        $creation_date = ""
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->video = $video;
        $this->status = $status;
        $this->contentType = $contentType;
        $this->creation_date = $creation_date;
        $this->db = Database::getInstance();
    }
    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    // Add a course
    public function addCours($title, $description, $content = "", $video_url = "", $contentType, $teacherID)
    {
        try {
            if (empty($title) || strlen($title) > 255) {
                return ["status" => 0, "message" => "Title must not exceed 255 characters."];
            }

            if (empty($description)) {
                return ["status" => 0, "message" => "Description is required."];
            }

            if (!in_array($contentType, ["Text", "Video"])) {
                return ["status" => 0, "message" => "Content type must be either 'Text' or 'Video'."];
            }

            if ($contentType === "Text" && empty($content)) {
                return ["status" => 0, "message" => "Content is required for text-based courses."];
            }

            if ($contentType === "Video" && (!filter_var($video_url, FILTER_VALIDATE_URL) || empty($video_url))) {
                return ["status" => 0, "message" => "Valid video URL is required for video-based courses."];
            }

            $query = "INSERT INTO Course (title, description, content, video_url, content_type, teacher_ID) 
                      VALUES (:title, :description, :content, :video_url, :contentType, :teacher_ID)";
            $this->db->query($query);
            $allCourses = [];
            $this->db->bind(':title', $title);
            $this->db->bind(':description', $description);
            $this->db->bind(':content', $content);
            $this->db->bind(':video_url', $video_url);
            $this->db->bind(':contentType', $contentType);
            $this->db->bind(':teacher_ID', $teacherID);

            $this->db->execute();
            $coursArray = $this->db->resultSet();
            foreach ($coursArray as $cours) {
                $allCourses[] = new Cours($cours["id"], $cours[" title "], $cours["description"], $cours["content"], $cours["vedio_url"], $cours["status"], $cours["content_type"], $cours["created_at"]);
            }
            return ["status" => 1, "message" => $allCourses, "course_id" => $this->db->lastInsertId()];
        } catch (PDOException $e) {
            return ["status" => 0, "error" => $e->getMessage()];
        }
    }
    // Update a course
    public function updateCourse($id, $title = "", $description = "", $content = "", $video = "", $contentType = "")
    {
        try {
            // Initialize the base query
            $query = "UPDATE Course SET ";
            $fields = [];

            // Dynamically add fields
            if (!empty($title)) {
                $fields[] = "title = :title";
            }
            if (!empty($description)) {
                $fields[] = "description = :description";
            }
            if (!empty($content)) {
                $fields[] = "content = :content";
            }
            if (!empty($video)) {
                $fields[] = "video_url = :video";
            }
            if (!empty($contentType)) {
                $fields[] = "content_type = :contentType";
            }

            // If no fields are updated, return early
            if (empty($fields)) {
                return ["status" => 0, "message" => "No fields to update."];
            }

            // Join fields and finalize query
            $query .= implode(", ", $fields) . " WHERE id = :id";

            // Prepare the query
            $this->db->query($query);

            // Bind parameters
            if (!empty($title)) {
                $this->db->bind(':title', $title);
            }
            if (!empty($description)) {
                $this->db->bind(':description', $description);
            }
            if (!empty($content)) {
                $this->db->bind(':content', $content);
            }
            if (!empty($video)) {
                $this->db->bind(':video', $video);
            }
            if (!empty($contentType)) {
                $this->db->bind(':contentType', $contentType);
            }
            $this->db->bind(':id', $id);

            // Execute and return result
            if ($this->db->execute()) {
                return ["status" => 1, "message" => "Course updated successfully."];
            } else {
                return ["status" => 0, "message" => "Failed to update course."];
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }


    // Delete a course
    public function deleteCourse($id)
    {
        try {
            $query = "DELETE FROM Course WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $executed = $this->db->execute();
            if ($executed) {
                return ["status" => 1, "message" => "Course deleted successfully."];
            } else {
                return ["status" => 0, "message" => "Failed to delete course."];
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }

    // List all approved courses
    public function listApprovedCourses()
    {
        try {
            $query = "SELECT * FROM Course WHERE status = 'accepted'";
            $this->db->query($query);
            $this->db->execute();

            $this->db->resultSet();
            $courses = $theCourses = [];

            foreach ($courses as $course) {
                $theCourses[] = new Cours($course["id"] ?? "", $course["title"] ?? "", $course["description"] ?? "", $course["content"] ?? "", $course["vedio_url"] ?? "", $course["status"] ?? "", $course["content_type"] ?? "");
            }

            if (!empty($theCourses)) {
                return ["status" => 1, "courses" => $theCourses];
            } else {
                return ["status" => 0, "message" => "No approved courses found."];
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }

    public function listCoursesByCategory($categoryName)
    {
        try {
            $query = "SELECT c.* 
                      FROM Course c
                      JOIN Course_Category cc ON c.id = cc.course_id
                      JOIN Category cat ON cc.category_id = cat.id
                      WHERE cat.name = :categoryName";
            $this->db->query($query);
            $this->db->bind(':categoryName', $categoryName);
            $this->db->execute();

            $courses = $this->db->resultSet();

            if ($courses) {
                return ["status" => 1, "courses" => $courses];
            } else {
                return ["status" => 0, "message" => "No courses found in the given category."];
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }

    public function getCourseDetails($id)
    {
        try {
            $query = "SELECT * FROM Course WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->execute();

            $result = $this->db->single();
            $theCours = new Cours($course["id"] ?? "", $course["title"] ?? "", $course["description"] ?? "", $course["content"] ?? "", $course["vedio_url"] ?? "", $course["status"] ?? "", $course["content_type"] ?? "");

            if ($result) {
                return [
                    "status" => 1,
                    "course" => $result
                ];
            } else {
                return [
                    "status" => 0,
                    "message" => "Course not found."
                ];
            }
        } catch (PDOException $e) {
            return [
                "status" => 0,
                "message" => "Error: " . $e->getMessage()
            ];
        }
    }
    public function searchCoursesByTitle($title)
    {
        try {
            $query = "SELECT * FROM Course WHERE title LIKE :title";
            $this->db->query($query);
            $searchTerm = '%' . $title . '%';
            $this->db->bind(':title', $searchTerm, );
            $this->db->execute();
            $courses = $this->db->resultSet();
            

            return json_encode([
                'status' => 1,
                'courses' => $courses
            ]);
        } catch (PDOException $e) {
            return json_encode([
                'status' => 0,
                'error' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    // List all courses (approved, rejected, pending)
    public function listAllCourses()
    {
        try {
            $query = "SELECT * FROM Course";
            $this->db->query($query);
            $this->db->execute();

            $courses = $this->db->resultSet();
            $theCourses = [];

            foreach ($courses as $course) {
                $theCourses[] = new Cours(
                    $course["id"] ?? "",
                    $course["title"] ?? "",
                    $course["description"] ?? "",
                    $course["content"] ?? "",
                    $course["vedio_url"] ?? "",
                    $course["status"] ?? "",
                    $course["content_type"] ?? "",
                    $course["created_at"]
                );
            }

            if (!empty($theCourses)) {
                return ["status" => 1, "courses" => $theCourses];
            } else {
                return ["status" => 0, "message" => "No courses found."];
            }
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
    public function changeStatus($id, $status)
    {
        try {
            $query = "UPDATE Course SET status = :status WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(":id", $id);
            $this->db->bind(":status", $status);
            $this->db->execute();
            return ["status" => 1, "message" => "Status updated successfully."];
        } catch (PDOException $e) {
            return ["status" => 0, "error" => "Error: " . $e->getMessage()];
        }
    }
}
?>