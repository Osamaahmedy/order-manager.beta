# Admin APIs

````
 GET http://127.0.0.1:8000/api/resident/orders/


the auth data
Authorization Bearer <Token> 

{
    "success": true,
    "count": 11,
    "orders": [
        {
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
        },
        {
            "id": 35,
            "order_number": "ORD-2026-000035",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-31 18:17",
            "branch": {
                "id": 1,
                "name": "اثار",
                "location": "لحج - صبر"
            },
            "delivery_app": null,
            "images": [
                {
                    "id": 92,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/92/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 93,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/93/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 34,
            "order_number": "ORD-2026-000034",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-31 18:17",
            "branch": {
                "id": 1,
                "name": "اثار",
                "location": "لحج - صبر"
            },
            "delivery_app": null,
            "images": [
                {
                    "id": 90,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/90/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 91,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/91/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 33,
            "order_number": null,
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-31 18:07",
            "branch": {
                "id": 1,
                "name": "اثار",
                "location": "لحج - صبر"
            },
            "delivery_app": null,
            "images": [
                {
                    "id": 88,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/88/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 89,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/89/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 32,
            "order_number": null,
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-31 18:06",
            "branch": {
                "id": 1,
                "name": "اثار",
                "location": "لحج - صبر"
            },
            "delivery_app": null,
            "images": [],
            "videos": []
        },
        {
            "id": 31,
            "order_number": "ORD-2026-000031",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-31 18:02",
            "branch": {
                "id": 1,
                "name": "اثار",
                "location": "لحج - صبر"
            },
            "delivery_app": null,
            "images": [],
            "videos": []
        },
        {
            "id": 30,
            "order_number": "ORD-2026-000030",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-31 18:02",
            "branch": {
                "id": 1,
                "name": "اثار",
                "location": "لحج - صبر"
            },
            "delivery_app": null,
            "images": [],
            "videos": []
        },
        {
            "id": 12,
            "order_number": "ORD-20260130-0001",
            "number": "1212",
            "notes": "س",
            "submitted_at": "2026-01-30 11:41",
            "branch": {
                "id": 4,
                "name": "admin",
                "location": "س"
            },
            "delivery_app": {
                "id": 1,
                "name": "كاريند"
            },
            "images": [
                {
                    "id": 70,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/70/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 71,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/71/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 11,
            "order_number": "ORD-20260129-0003",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-29 16:15",
            "branch": {
                "id": 4,
                "name": "admin",
                "location": "س"
            },
            "delivery_app": null,
            "images": [
                {
                    "id": 68,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/68/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 69,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/69/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 10,
            "order_number": "ORD-20260129-0002",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-29 16:15",
            "branch": {
                "id": 4,
                "name": "admin",
                "location": "س"
            },
            "delivery_app": null,
            "images": [
                {
                    "id": 66,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/66/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 67,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/67/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        },
        {
            "id": 9,
            "order_number": "ORD-20260129-0001",
            "number": "1212",
            "notes": null,
            "submitted_at": "2026-01-29 16:14",
            "branch": {
                "id": 4,
                "name": "admin",
                "location": "س"
            },
            "delivery_app": null,
            "images": [
                {
                    "id": 64,
                    "name": "Screenshot-from-2025-07-11-17-31-06.png",
                    "url": "http://127.0.0.1:8000/storage/64/Screenshot-from-2025-07-11-17-31-06.png",
                    "size": "300.42 KB"
                },
                {
                    "id": 65,
                    "name": "Screenshot-from-2025-07-11-21-07-27.png",
                    "url": "http://127.0.0.1:8000/storage/65/Screenshot-from-2025-07-11-21-07-27.png",
                    "size": "109.26 KB"
                }
            ],
            "videos": []
        }
    ]
}

````

# TO POST DATA

POST http://127.0.0.1:8000/api/resident/orders/


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
        "id": 41,
        "order_number": "ORD-2026-000041",
        "number": "1212",
        "notes": null,
        "submitted_at": "2026-02-01 14:38",
        "branch": {
            "id": 1,
            "name": "اثار",
            "location": "لحج - صبر"
        },
        "delivery_app": {
            "id": 1,
            "name": "كاريند"
        },
        "images_count": 2,
        "images": [
            {
                "id": 101,
                "name": "Screenshot-from-2025-07-11-17-31-06.png",
                "url": "http://127.0.0.1:8000/storage/101/Screenshot-from-2025-07-11-17-31-06.png",
                "size": "300.42 KB"
            },
            {
                "id": 102,
                "name": "Screenshot-from-2025-07-11-21-07-27.png",
                "url": "http://127.0.0.1:8000/storage/102/Screenshot-from-2025-07-11-21-07-27.png",
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
**Or**
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
        "total": 13,
        "this_month": 3,
        "today": 3
    }
}
````

# orders/{id}

**http://127.0.0.1:8000/api/resident/orders/{id}**

````
{
    "success": true,
    "order": {
        "id": 41,
        "order_number": "ORD-2026-000041",
        "number": "1212",
        "notes": null,
        "submitted_at": "2026-02-01 14:38",
        "branch": {
            "id": 1,
            "name": "اثار",
            "location": "لحج - صبر"
        },
        "delivery_app": {
            "id": 1,
            "name": "كاريند"
        },
        "images": [
            {
                "id": 101,
                "name": "Screenshot-from-2025-07-11-17-31-06.png",
                "url": "http://127.0.0.1:8000/storage/101/Screenshot-from-2025-07-11-17-31-06.png",
                "size": "300.42 KB",
                "mime_type": "image/png",
                "created_at": "2026-02-01 14:38"
            },
            {
                "id": 102,
                "name": "Screenshot-from-2025-07-11-21-07-27.png",
                "url": "http://127.0.0.1:8000/storage/102/Screenshot-from-2025-07-11-21-07-27.png",
                "size": "109.26 KB",
                "mime_type": "image/png",
                "created_at": "2026-02-01 14:38"
            }
        ],
        "videos": []
    }
}
````