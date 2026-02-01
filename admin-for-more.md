# Admin Branches
**http://127.0.0.1:8000/api/admin/branches/**

````
{
    "success": true,
    "count": 1,
    "branches": [
        {
            "id": 5,
            "name": "seven",
            "type": null,
            "location": "عدن - الشيخ عثمان ",
            "residents_count": 1,
            "created_at": "2026-01-31"
        }
    ]
}
````

# Available Residents
**http://127.0.0.1:8000/api/admin/available-residents**

````
{
    "success": true,
    "count": 1,
    "residents": [
        {
            "id": 7,
            "name": "osvu",
            "phone": "718323599",
            "branch_id": 5,
            "branch": {
                "id": 5,
                "name": "seven"
            }
        }
    ]
}
````
