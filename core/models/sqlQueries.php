<?php

return [
    "insertUser" => "INSERT INTO usersTable (email, fullName, gender, status)
                    VALUES (:email, :fullName, :gender, :status)",
    "checkEmpty" => "SELECT COUNT(*) FROM usersTable"
];