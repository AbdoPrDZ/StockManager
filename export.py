import sqlite3

# Connect to SQLite database
sqlite_conn = sqlite3.connect('database.db')
sqlite_cursor = sqlite_conn.cursor()

# Fetch all table names from SQLite database
tables = [
  'brands',
  'products',
  'orders',
  'order_products',
]

# Export each table as SQL with UTF-8 encoding
with open("export.sql", "w", encoding="utf-8") as sql_file:
    for table_name in tables:
        sqlite_cursor.execute(f"SELECT * FROM {table_name}")
        rows = sqlite_cursor.fetchall()

        # Get column names
        column_names = [description[0] for description in sqlite_cursor.description]
        columns = '`' + '`, `'.join(column_names) + '`'

        # Write SQL INSERT statements to file
        for row in rows:
            values = ', '.join([f"'{str(value).replace('\'', '\'\'')}'" if value is not None else 'NULL' for value in row])
            sql_file.write(f"INSERT INTO {table_name} ({columns}) VALUES ({values});\n")

# Close the SQLite connection
sqlite_conn.close()
