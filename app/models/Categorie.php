<?php
class Categorie
{
    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $catigoryImage = null;
    protected ?string $coursCount = null;
    protected $db;

    public function __construct($id = null, $name = null, $catigoryImage = null , $coursCount = null)
    {
        $this->db = Database::getInstance();
        $this->id = $id;
        $this->name = $name;
        $this->coursCount=$coursCount;
        $this->catigoryImage= $catigoryImage;
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function createCategories(array $categories): array
    {
        try {
            foreach ($categories as $category) {
                $this->db->query("INSERT INTO Category (name) VALUES (:name)");
                $this->db->bind(':name', $category);
                $this->db->execute();
            }
            return ['status' => 1, 'message' => count($categories) . " categories created successfully."];
        } catch (PDOException $e) {
            return ['status' => 0, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function deleteCategory(int $id): array
    {
        try {
            $this->db->query("DELETE FROM Category WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();
            return ['status' => 1, 'message' => "Category deleted successfully."];
        } catch (PDOException $e) {
            return ['status' => 0, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function listCategories(): array
    {
        try {
            $this->db->query("SELECT * FROM Category");
            $categories = $this->db->resultSet();
            $allcatigorys = [];
            foreach ($categories as $categorie) {
                $allcatigorys [] = new Categorie($categorie["id"], $categorie["name"], $categorie["catImage"] );
            }
            return ['status' => 1, 'categories' => $allcatigorys];
        } catch (PDOException $e) {
            return ['status' => 0, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function getCategoryCourseCounts(): array
    {
        try {
            $sql = "SELECT id AS category_id, name AS category_name, catImage AS category_image, 
                    (SELECT COUNT(*) FROM Course_Category WHERE Course_Category.category_id = Category.id) AS course_count
                    FROM Category ORDER BY name";
            $this->db->query($sql);
            $categories = $this->db->resultSet();
            $allcatigorys = [];
            foreach ($categories as $categorie) {
                $allcatigorys [] = new Categorie($categorie["category_id"], $categorie["category_name"], $categorie["category_image"], $categorie["course_count"]);;
            }
            return ['status' => 1, 'categories' => $allcatigorys];
        } catch (PDOException $e) {
            return ['status' => 0, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function assignCategories(int $categoryId, int $courseId): array
    {
        try {
            $this->db->query("INSERT INTO Course_Category (course_id, category_id) VALUES (:course_id, :category_id)");
            $this->db->bind(':course_id', $courseId);
            $this->db->bind(':category_id', $categoryId);
            $this->db->execute();
            return ['status' => 1, 'message' => "Category assigned to the course successfully."];
        } catch (PDOException $e) {
            return ['status' => 0, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }
}
