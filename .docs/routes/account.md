# Routes: Account

## Base URI

    /api/account

---

## Routes

- [Deposit](#deposit)
- [Withdraw](#withdraw)

---

### Deposit

#### Route

    POST /deposit

#### Header

    Authorization: Bearer #Token#

#### Payload

```json
{
	"amount": 1000
}
```

#### Response

##### Status: 201

---

### Withdraw

#### Route

    POST /withdraw

#### Header

    Authorization: Bearer #Token#

#### Payload

```json
{
	"amount": 1000
}
```

#### Response

##### Status: 201

---
