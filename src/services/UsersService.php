<?php


class UserService
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM users";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $row["lastName"] = (bool) $row["lastName"];
            
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO users (email, firstName, lastName)
                VALUES (:email, :firstName, :lastName)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
        $stmt->bindValue(":firstName", $data["firstName"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":lastName", (bool) ($data["lastNama"] ?? false), PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM users
                WHERE id = :id";
            
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            $data["lastName"] = (bool) $data["lastName"];
        }

        return $data;
    }

    public function update(array $current, array $new): int
        {
            $sql = "UPDATE users
                    SET  email = :email, firstName = :firstName, lastName = :lastName
                    WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":email", $new["email"] ?? $current["email"], PDO::PARAM_STR);
            $stmt->bindValue(":firstName", $new["firstName"] ?? $current["firstName"], PDO::PARAM_INT);
            $stmt->bindValue(":lastName", $new["lastName"] ?? $current["lastName"], PDO::PARAM_BOOL);

            $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount();
        }

        public function delete(string $id): int
        {
            $sql = "DELETE FROM users
                    WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->rowCount();
        }
}