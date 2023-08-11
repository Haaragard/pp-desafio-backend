# Routes: User

Base URI

`/api/user`

---

## Routes

- [Login](#login)

---

### Login

#### Request

##### Route

    POST /

##### Payload

```json
{
	"email": "test@gmail.com",
	"password": "12345678"
}
```

#### Response

##### Status: 201

```json
{
	"token": "6|kgkU4sgpYc0YSEbnB6GTPuYv8MMZCGO4tZmzyk6I"
}
```

---
