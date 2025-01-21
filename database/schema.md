Table roles {
  id integer [pk]
  name varchar(255)
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table companies {
  id integer [pk]
  name varchar(255)
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table users {
  id integer [pk]
  name varchar(255) [not null]
  email varchar(255) [not null, unique]
  email_verified_at timestamp
  password varchar(255) [not null]
  role_id integer [not null]
  company_id integer [not null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: users.role_id > roles.id
Ref: users.company_id > companies.id

Table bank_accounts {
  id integer [pk]
  name varchar(255) [not null]
  balance decimal(10, 2) [not null]
  company_id integer [not null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: bank_accounts.company_id > companies.id

Table categories {
  id integer [pk]
  name varchar(255) [not null]
  movement_type enum('entry', 'exit') [not null]
  parent_id integer
  company_id integer [not null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: categories.parent_id > categories.id
Ref: categories.company_id > companies.id

Table financial_accounts {
  id integer [pk]
  description varchar(255)
  due_date date [not null]
  payment_date date
  projected_amount decimal(10, 2) [not null]
  paid_amount decimal(10, 2)
  movement_type enum('entry', 'exit') [not null]
  status enum('pending', 'paid', 'overdue') [not null, default: 'pending']
  category_id integer [not null]
  company_id integer [not null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: financial_accounts.category_id > categories.id
Ref: financial_accounts.company_id > companies.id

Table installments {
  id integer [pk]
  number integer [not null]
  due_date date [not null]
  payment_date date
  projected_amount decimal(10, 2) [not null]
  paid_amount decimal(10, 2)
  status enum('pending', 'paid', 'overdue') [not null, default: 'pending']
  financial_account_id integer [not null]
  company_id integer [not null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: installments.financial_account_id > financial_accounts.id
Ref: installments.company_id > companies.id

Table transactions {
  id integer [pk]
  description varchar(255)
  amount decimal(10, 2) [not null]
  movement_type enum('entry', 'exit') [not null]
  reference_id integer
  reference_type varchar(255)
  category_id integer [not null]
  bank_account_id integer [not null]
  company_id integer [not null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Ref: transactions.category_id > categories.id
Ref: transactions.bank_account_id > bank_accounts.id
Ref: transactions.company_id > companies.id