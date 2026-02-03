<?php

class Profile extends Model
{
    /**
     * Ambil profile berdasarkan user_id
     */
    public function findByUserId($userId)
    {
        $this->db->query("SELECT * FROM user_profiles WHERE user_id = :user_id LIMIT 1");
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    /**
     * Buat profile baru untuk user
     */
    public function create($data)
    {
        $this->db->query("
            INSERT INTO user_profiles 
            (user_id, phone, birth_place, birth_date, gender, address, city, province, postal_code, country)
            VALUES 
            (:user_id, :phone, :birth_place, :birth_date, :gender, :address, :city, :province, :postal_code, :country)
        ");

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':phone', $data['phone'] ?? null);
        $this->db->bind(':birth_place', $data['birth_place'] ?? null);
        $this->db->bind(':birth_date', $data['birth_date'] ?? null);
        $this->db->bind(':gender', $data['gender'] ?? null);
        $this->db->bind(':address', $data['address'] ?? null);
        $this->db->bind(':city', $data['city'] ?? null);
        $this->db->bind(':province', $data['province'] ?? null);
        $this->db->bind(':postal_code', $data['postal_code'] ?? null);
        $this->db->bind(':country', $data['country'] ?? 'Indonesia');

        return $this->db->execute();
    }

    /**
     * Update profile user
     */
    public function update($userId, $data)
    {
        $this->db->query("
            UPDATE user_profiles SET
                phone = :phone,
                birth_place = :birth_place,
                birth_date = :birth_date,
                gender = :gender,
                address = :address,
                city = :city,
                province = :province,
                postal_code = :postal_code,
                country = :country,
                updated_at = NOW()
            WHERE user_id = :user_id
        ");

        $this->db->bind(':user_id', $userId);
        $this->db->bind(':phone', $data['phone'] ?? null);
        $this->db->bind(':birth_place', $data['birth_place'] ?? null);
        $this->db->bind(':birth_date', $data['birth_date'] ?? null);
        $this->db->bind(':gender', $data['gender'] ?? null);
        $this->db->bind(':address', $data['address'] ?? null);
        $this->db->bind(':city', $data['city'] ?? null);
        $this->db->bind(':province', $data['province'] ?? null);
        $this->db->bind(':postal_code', $data['postal_code'] ?? null);
        $this->db->bind(':country', $data['country'] ?? 'Indonesia');

        return $this->db->execute();
    }

    /**
     * Cek apakah profile sudah lengkap
     * Return: true jika lengkap, false jika belum
     */
    public function isComplete($profile)
    {
        if (!$profile) {
            return false;
        }

        $required = [
            'phone',
            'birth_place',
            'birth_date',
            'address',
            'city',
            'province',
            'postal_code'
        ];

        foreach ($required as $field) {
            if (empty($profile[$field])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create or update profile (upsert)
     */
    public function save($userId, $data)
    {
        $existing = $this->findByUserId($userId);

        if ($existing) {
            return $this->update($userId, $data);
        } else {
            $data['user_id'] = $userId;
            return $this->create($data);
        }
    }
}
