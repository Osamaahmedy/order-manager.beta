# Admin APIs

````
 GET http://127.0.0.1:8000/api/admin/orders/


the auth data
Authorization Bearer <Token> 

{
    "success": true,
    "count": 10,
    "orders": [
        {
            "id": 38,
            "order_number": "ORD-2026-000038",
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 18:17",
            "created_at": "2026-01-31 18:17",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [
                {
                    "id": 96,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/96/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 37,
            "order_number": "ORD-2026-000037",
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 18:17",
            "created_at": "2026-01-31 18:17",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [
                {
                    "id": 95,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/95/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 36,
            "order_number": "ORD-2026-000036",
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 18:17",
            "created_at": "2026-01-31 18:17",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [
                {
                    "id": 94,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/94/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 29,
            "order_number": "ORD-2026-000029",
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 18:01",
            "created_at": "2026-01-31 18:01",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [],
            "videos": []
        },
        {
            "id": 28,
            "order_number": "ORD-2026-000028",
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 18:00",
            "created_at": "2026-01-31 18:00",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [],
            "videos": []
        },
        {
            "id": 27,
            "order_number": null,
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 17:59",
            "created_at": "2026-01-31 17:59",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [],
            "videos": []
        },
        {
            "id": 26,
            "order_number": null,
            "number": "454",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 17:58",
            "created_at": "2026-01-31 17:58",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [],
            "videos": []
        },
        {
            "id": 25,
            "order_number": "ORD-20260131-0009",
            "number": "45646",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 17:24",
            "created_at": "2026-01-31 17:24",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [],
            "videos": []
        },
        {
            "id": 24,
            "order_number": "ORD-20260131-0008",
            "number": "45646",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 09:33",
            "created_at": "2026-01-31 09:33",
            "is_admin_created": true,
            "created_by": {
                "type": "admin",
                "id": 4,
                "name": "اسامه"
            },
            "resident": null,
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [
                {
                    "id": 86,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/86/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 23,
            "order_number": "ORD-20260131-0007",
            "number": "45646",
            "notes": "5555555jhi",
            "submitted_at": "2026-01-31 09:31",
            "created_at": "2026-01-31 09:31",
            "is_admin_created": false,
            "created_by": {
                "type": "resident",
                "id": 7,
                "name": "osvu"
            },
            "resident": {
                "id": 7,
                "name": "osvu",
                "phone": "718323599"
            },
            "branch": {
                "id": 5,
                "name": "seven",
                "location": "عدن - الشيخ عثمان "
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [
                {
                    "id": 85,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/85/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        }
    ]
}

````

# TO POST DATA

POST http://127.0.0.1:8000/api/admin/orders/


the auth data
Authorization Bearer <Token>

THE DATA

````
1. branch_id:number
2. images[]:image.png
3. notes:string
4. delivery_app_id:number
5. number:55555555

````
**وصف البيانات يا مجد**

1. branch_id:  تاخذه من الفروع
2. images[]:image.png  عشان ترسل اكثر من صوه كرر
2. images[]:image.png
2. images[]:image.png

3. notes:  ملاحظه
4. delivery_app_id:   تاخذه من api التطبيقات 
5. number: رقم الفاتوره

**Respons** 200
````
{
    "success": true,
    "message": "تم إنشاء الطلب بنجاح",
    "order": {
        "id": 39,
        "order_number": "ORD-2026-000039",
        "number": "1212",
        "notes": null,
        "submitted_at": "2026-02-01 14:29",
        "branch": {
            "id": 1,
            "name": "اثار",
            "location": "لحج - صبر"
        },
        "delivery_app": null,
        "images_count": 2,
        "images": [
            {
                "id": 97,
                "name": "Screenshot-from-2025-07-11-17-31-06.png",
                "url": "http://127.0.0.1:8000/storage/97/Screenshot-from-2025-07-11-17-31-06.png",
                "size": "300.42 KB"
            },
            {
                "id": 98,
                "name": "Screenshot-from-2025-07-11-21-07-27.png",
                "url": "http://127.0.0.1:8000/storage/98/Screenshot-from-2025-07-11-21-07-27.png",
                "size": "109.26 KB"
            }
        ],
        "videos": []
    }
}
````
**Respons** 422
````
{
    "success": false,
    "message": "خطأ في البيانات المدخلة",
    "errors": {
        "number": [
            "رقم الطلب مطلوب"
        ],
        "branch_id": [
            "الفرع مطلوب"
        ]
    }
}

````
**OR**
````
{
    "success": false,
    "message": "خطأ في البيانات المدخلة",
    "errors": {
        "branch_id": [
            "الفرع المحدد غير موجود"
        ]
    }
}
````

**OR**
````
{
    "success": false,
    "message": "خطأ في البيانات المدخلة",
    "errors": {
        "delivery_app_id": [
            "تطبيق التوصيل المحدد غير موجود"
        ]
    }
}
````

**Respons** 403

````
{
    "success": false,
    "message": "الفرع المحدد غير تابع للمسؤولين المرتبطين بك"
}
````


# Orders Statistics

**http://127.0.0.1:8000/api/admin/orders/statistics/**/

````
{
    "success": true,
    "statistics": {
        "total": 10,
        "today": 0,
        "this_week": 10,
        "this_month": 0,
        "admin_created": 9,
        "resident_created": 1,
        "branches": [
            {
                "branch_id": 5,
                "branch_name": "seven",
                "orders_count": 10,
                "today": 0,
                "admin_created": 9,
                "resident_created": 1
            }
        ]
    }
}
````


# orders/{id}

**http://127.0.0.1:8000/api/admin/orders/{id}**

````
{
    "success": true,
    "order": {
        "id": 38,
        "order_number": "ORD-2026-000038",
        "number": "454",
        "notes": "5555555jhi",
        "submitted_at": "2026-01-31 18:17",
        "created_at": "2026-01-31 18:17",
        "is_admin_created": true,
        "created_by": null,
        "resident": null,
        "branch": {
            "id": 5,
            "name": "seven",
            "location": "عدن - الشيخ عثمان "
        },
        "delivery_app": {
            "id": 1,
            "name": "كاريند"
        },
        "images": [
            {
                "id": 96,
                "name": "Screenshot-from-2025-07-11-21-07-27.png",
                "url": "http://127.0.0.1:8000/storage/96/Screenshot-from-2025-07-11-21-07-27.png",
                "size": "109.26 KB",
                "mime_type": "image/png",
                "created_at": "2026-01-31 18:17"
            }
        ],
        "videos": []
    }
}
````
