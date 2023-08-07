# DB
### Use DBML to define your database structure
- [docs](https://dbml.dbdiagram.io/docs)
- [website](https://dbdiagram.io/d)

## Definition
- Just paste the cove above into the **website**
````sql
Table users {
  id integer [primary key]
  userable_type varchar
  userable_id integer [ref: > persons.id, ref: > companies.id]
  name varchar
  email varchar
  password varchar
  created_at timestamp
  updated_at timestamp
}

table persons {
  id integer [primary key]
  uuid uuid
  user_id integer [ref: > users.id]
  cpf varchar(11)
  created_at timestamp
  updated_at timestamp
}

table companies {
  id integer [primary key]
  uuid uuid
  user_id integer [ref: > users.id]
  cnpj varchar(14)
  created_at timestamp
  updated_at timestamp
}

table accounts {
  id integer [primary key]
  user_id integer [ref: > users.id]
  balance integer
  future_balance integer
}

table transactions {
  id integer [primary key]
  uuid uuid
  payer_id integer [ref: > users.id, note: "user_id, this one pays"]
  payee_id integer [ref: > users.id, note: "user_id, this one receives"]
  amount integer
  approved_at timestamp
  reproved_at timestamp
  created_at timestamp
  updated_at timestamp
}
````