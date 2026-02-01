# Admin Branches
**http://127.0.0.1:8000/api/resident/branches/**

````
{
    "success": true,
    "branch": {
        "id": 4,
        "name": "admin",
        "location": "س",
        "is_active": true,
        "created_at": "2026-01-29",
        "admins": [
            {
                "id": 1,
                "name": "Osama Ahmed",
                "email": "asasa@gmail.come",
                "phone": "0718323599"
            }
        ]
    }
}
````
# Orders/Statistics

**http://127.0.0.1:8000/api/resident/orders/statistics**

````

{
    "success": true,
    "statistics": {
        "total": 13,
        "this_month": 3,
        "today": 3
    }
}
````
