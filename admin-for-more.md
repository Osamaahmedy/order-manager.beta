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



# Subscription Renewals
**POST http://127.0.0.1:8000/api/admin/subscription-renewals**

البوست  يا مجد داتا فورم 

transfer_number:number

image:file

notes:string

**Response** **201**

````
{
    "success": true,
    "message": "تم إرسال طلب التجديد بنجاح",
    "data": {
        "id": 6,
        "transfer_number": "545645",
        "status": null,
        "status_text": "قيد الانتظار",
        "created_at": "2026-02-01 14:58:10"
    }
}
````
**Response** **422**

````
{
    "success": false,
    "message": "خطأ في البيانات المدخلة",
    "errors": {
        "transfer_number": [
            "رقم الحوالة مطلوب"
        ]
    }
}
````
**Response** **400**

````
{
    "success": false,
    "message": "لديك طلب قيد الانتظار بالفعل"
}
````



**Get http://127.0.0.1:8000/api/admin/subscription-renewals**

````
{
    "success": true,
    "data": [
        {
            "id": 6,
            "transfer_number": "545645",
            "notes": "fyufy",
            "status": "pending",
            "status_text": "قيد الانتظار",
            "image_url": "http://127.0.0.1:8000/storage/103/Screenshot-from-2025-07-11-21-06-11.png",
            "reviewed_at": null,
            "created_at": "2026-02-01 14:58:10"
        },
        {
            "id": 5,
            "transfer_number": "545645",
            "notes": null,
            "status": "approved",
            "status_text": "تم التجديد",
            "image_url": "http://127.0.0.1:8000/storage/87/Screenshot-from-2025-07-11-21-06-11.png",
            "reviewed_at": "2026-01-31 15:34:34",
            "created_at": "2026-01-31 12:35:43"
        }
    ]
}

````