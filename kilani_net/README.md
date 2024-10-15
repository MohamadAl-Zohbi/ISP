SELECT COUNT(*),checked_by_owner FROM renews,customers WHERE renews.customer_id = customers.id
AND
renews.created_at BETWEEN '2024-10-13' AND '2024-10-14'

GROUP BY checked_by_owner