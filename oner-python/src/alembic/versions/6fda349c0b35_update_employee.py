"""update employee

Revision ID: 6fda349c0b35
Revises: c062f6a1c649
Create Date: 2021-12-08 14:52:36.349857

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = '6fda349c0b35'
down_revision = 'c062f6a1c649'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
   
    op.add_column('employee', sa.Column('created_user_id', sa.BigInteger(), nullable=False))
    op.add_column('employee', sa.Column('updated_user_id', sa.BigInteger(), nullable=False))
    op.execute("UPDATE employee SET created_user_id = 1")
    op.execute("UPDATE employee SET updated_user_id = 1")
    op.alter_column('employee', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.alter_column('employee', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('employee', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=True)
    op.alter_column('employee', 'phone_number',
               existing_type=mysql.VARCHAR(length=25),
               nullable=True)
    op.alter_column('employee', 'position_id',
               existing_type=mysql.BIGINT(),
               nullable=True)
    op.alter_column('employee', 'department_id',
               existing_type=mysql.BIGINT(),
               nullable=True)
    op.alter_column('employee', 'status',
               existing_type=mysql.INTEGER(),
               nullable=True,
               comment=None,
               existing_comment='0 = Resigned, 1 = Probation, 2 = Permanent',
               existing_server_default=sa.text("'1'"))
    op.create_index(op.f('ix_employee_id'), 'employee', ['id'], unique=False)
    op.create_foreign_key(None, 'employee', 'user', ['created_user_id'], ['id'])
    op.create_foreign_key(None, 'employee', 'user', ['updated_user_id'], ['id'])
    op.drop_column('employee', 'created_user_login_id')
    op.drop_column('employee', 'passport_number')
    op.drop_column('employee', 'permanent_date')
    op.drop_column('employee', 'profile_image')
    op.drop_column('employee', 'live_with_parent')
    op.drop_column('employee', 'tax_id')
    op.drop_column('employee', 'employee_identification_number')
    op.drop_column('employee', 'updated_user_login_id')
    op.drop_column('employee', 'join_date')


    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###


    op.add_column('employee', sa.Column('join_date', sa.DATE(), nullable=True))
    op.add_column('employee', sa.Column('updated_user_login_id', mysql.BIGINT(), autoincrement=False, nullable=True))
    op.add_column('employee', sa.Column('employee_identification_number', mysql.VARCHAR(length=255), nullable=True))
    op.add_column('employee', sa.Column('tax_id', mysql.VARCHAR(length=50), nullable=True))
    op.add_column('employee', sa.Column('live_with_parent', mysql.ENUM('Yes', 'No'), server_default=sa.text("'No'"), nullable=True))
    op.add_column('employee', sa.Column('profile_image', mysql.LONGTEXT(), nullable=True))
    op.add_column('employee', sa.Column('permanent_date', sa.DATE(), nullable=True))
    op.add_column('employee', sa.Column('passport_number', mysql.VARCHAR(length=50), nullable=True))
    op.add_column('employee', sa.Column('created_user_login_id', mysql.BIGINT(), autoincrement=False, nullable=True))
    op.drop_constraint(None, 'employee', type_='foreignkey')
    op.drop_constraint(None, 'employee', type_='foreignkey')
    op.drop_index(op.f('ix_employee_id'), table_name='employee')
    op.alter_column('employee', 'status',
               existing_type=mysql.INTEGER(),
               nullable=False,
               comment='0 = Resigned, 1 = Probation, 2 = Permanent',
               existing_server_default=sa.text("'1'"))
    op.alter_column('employee', 'department_id',
               existing_type=mysql.BIGINT(),
               nullable=False)
    op.alter_column('employee', 'position_id',
               existing_type=mysql.BIGINT(),
               nullable=False)
    op.alter_column('employee', 'phone_number',
               existing_type=mysql.VARCHAR(length=25),
               nullable=False)
    op.alter_column('employee', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=False)
    op.alter_column('employee', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('employee', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.drop_column('employee', 'updated_user_id')
    op.drop_column('employee', 'created_user_id')
   
    # ### end Alembic commands ###
