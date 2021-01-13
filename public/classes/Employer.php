<?php

class Employer
{
    private const FILENAME = 'others.txt'; // Imitating DATABASE

    private string $name; // Given name from input
    private bool $experienced; // Checkbox from form for additional information
    private string $message; // Variable for displaying messages

    /**
     * Employer constructor.
     * @param string $name
     * @param bool $experienced
     */
    public function __construct(string $name, bool $experienced = false)
    {
        $this->name = $name;
        $this->experienced = $experienced;

        $this->addEmployee();
    }

    /**
     * Adding employee.
     * Checking whether it has experience or not, because it depends which type to save the name
     */
    private function addEmployee(): void
    {
        if ($this->experienced) {
            $this->insert(true);
            return;
        }

        if (!$this->candidateExistsInFile()) {
            $this->insert();
            return;
        }

    }

    /**
     * Checking for existing candidate if it does not have experience and are already added to the list
     *
     * @return bool
     */
    private function candidateExistsInFile(): bool
    {
        $candidates = explode("\n", trim(file_get_contents(self::FILENAME)));

        foreach ($candidates as $candidate) {
            if ($candidate === $this->name) {
                $this->message = 'Inexperienced candidate exists in our text file';
                return true;
            }
        }

        return false;
    }

    /**
     * Inserting into one or another way depending addEmployee function which return here boolean where to save
     * and set the message if added
     *
     * @param bool $storage
     */
    private function insert(bool $storage = false): void
    {
        if ($storage) {
            $_SESSION['experienced_employees'][] = $this->name;
            $this->message = 'Experienced candidate added to session';
        } else {
            file_put_contents(self::FILENAME, $this->name . "\n", FILE_APPEND);
            $this->message = 'Inexperienced candidate added to text file';
        }
    }

    /**
     * Message getter for displaying in index
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Returning list which is saved to session (Storage)
     *
     * @return array|null
     */
    public static function displaySessionList(): ?array
    {
        return $_SESSION['experienced_employees'] ?? null;
    }

    /**
     * Returning list which is saved to text file
     *
     * @return array|null
     */
    public static function displayTextFileList(): ?array
    {
        return explode("\n", trim(file_get_contents(self::FILENAME))) ?? null;
    }

    /**
     * Just to reset the session, in this case our list of session (storage)
     */
    public static function resetSessionList(): void
    {
        session_destroy();
        header('Location: http://' . $_SERVER['HTTP_HOST']);
    }

    /**
     * Just to reset the text file and make it empty, in this case our text file from constant FILENAME
     */
    public static function resetTextFileList(): void
    {
        file_put_contents(self::FILENAME, "");
    }
}
