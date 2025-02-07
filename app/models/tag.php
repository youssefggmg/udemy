<?php
class tag
{
    private $name;
    private $db;
    public function __construct($name)
    {
        $this->name = $name;
        $this->db = Database::getInstance();
    }
    public function createTags($tags, $numTags)
    {
        try {

            $placeholders = array_fill(0, $numTags, "(?)");
            $sql = "INSERT INTO Tag (name) VALUES " . implode(", ", $placeholders);

            $this->db->query($sql);

            for ($i = 0; $i < $numTags; $i++) {
                $this->db->bind($i + 1, $tags["tag" . ($i + 1)]);
            }

            $this->db->execute();

            return ["status" => 1, "message" => "$numTags tags created successfully."];
        } catch (PDOException $e) {
            return [
                "status" => 0,
                "error" => "Error: " . $e->getMessage()
            ];
        }
    }
    public function deleteTag($id)
    {
        try {
            $sql = "DELETE FROM Tag WHERE id = :id";
            $stmt = $this->db->query($sql);
            $this->db->bind(':id', $id);
            return ["status" => 1, "message" => "Tag deleted successfully."];
        } catch (PDOException $e) {
            return [
                "status" => 0,
                "error" => "Error: " . $e->getMessage()
            ];
        }
    }
    public function listTags()
    {
        try {
            $sql = "SELECT * FROM Tag ";
            $this->db->query($sql);
            $this->db->execute();
            $tags=$this->db->resultSet();
            return ["status" => 1, "message" => $tags];
        } catch (PDOException $e) {
            return [
                "status" => 0,
                "error" => "Error: " . $e->getMessage()
            ];
        }
    }
    public function asignTags($tags, $courseId)
    {
        try {
            $sql = "INSERT INTO Course_Tag (course_id,tag_id) VALUES (:course_id, :tag_id)";
            foreach ($tags as $tag) {
                $this->db->query($sql);
                $this->db->bind(':course_id', $courseId);
                $this->db->bind(':tag_id', $tag);
                $this->db->execute();
            }
        } catch (PDOException $e) {
            return [
                "status" => 0,
                "error" => "Error: " . $e->getMessage()
            ];
        }
    }
}
?>