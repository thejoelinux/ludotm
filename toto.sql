SELECT id, lastname, firstname, birth_date,
    DATE_ADD(
        birth_date, 
        INTERVAL IF(DAYOFYEAR(birth_date) >= DAYOFYEAR(CURDATE()),
            YEAR(CURDATE())-YEAR(birth_date),
            YEAR(CURDATE())-YEAR(birth_date)+1
        ) YEAR
    ) AS `next_birthday`
FROM members 
WHERE 
    `birth_date` IS NOT NULL
HAVING 
    `next_birthday` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)

UNION

SELECT id, lastname, firstname, birth_date,
    DATE_ADD(
        birth_date, 
        INTERVAL IF(DAYOFYEAR(birth_date) >= DAYOFYEAR(CURDATE()),
            YEAR(CURDATE())-YEAR(birth_date),
            YEAR(CURDATE())-YEAR(birth_date)+1
        ) YEAR
    ) AS `next_birthday`
FROM family_members 
WHERE 
    `birth_date` IS NOT NULL
HAVING 
    `next_birthday` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)

ORDER BY `next_birthday`


			SELECT id, lastname, firstname, birth_date,
				DATE_ADD(
					birth_date, 
					INTERVAL YEAR(CURDATE())-YEAR(birth_date) YEAR
				) AS `next_birthday`,
            YEAR(CURDATE())-YEAR(birth_date) AS age

			FROM members 
			WHERE 
				`birth_date` IS NOT NULL
			HAVING 
				`next_birthday` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(CURDATE())

			UNION

			SELECT id, lastname, firstname, birth_date,
				DATE_ADD(
					birth_date, 
					INTERVAL YEAR(CURDATE())-YEAR(birth_date) YEAR
				) AS `next_birthday`,
            YEAR(CURDATE())-YEAR(birth_date) AS age
			FROM family_members 
			WHERE 
				`birth_date` IS NOT NULL
			HAVING 
				`next_birthday` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(CURDATE())
			ORDER BY `next_birthday`
