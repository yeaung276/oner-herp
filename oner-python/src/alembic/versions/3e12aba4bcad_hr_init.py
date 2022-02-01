"""hr init

Revision ID: 3e12aba4bcad
Revises: f9b4648bf129
Create Date: 2021-12-08 14:43:37.255816

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = '3e12aba4bcad'
down_revision = 'f9b4648bf129'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.add_column('department', sa.Column('created_time', sa.DateTime(timezone=True), nullable=True))
    op.add_column('department', sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True))
    op.add_column('department', sa.Column('created_user_id', sa.BigInteger(), nullable=False))
    op.add_column('department', sa.Column('updated_user_id', sa.BigInteger(), nullable=False))
    op.execute("UPDATE department SET created_user_id = 1")
    op.execute("UPDATE department SET updated_user_id = 1")
    op.alter_column('department', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=True)
    op.alter_column('department', 'description',
               existing_type=mysql.TEXT(),
               nullable=True)
    op.drop_index('id_2', table_name='department')
    op.create_index(op.f('ix_department_id'), 'department', ['id'], unique=False)
    op.create_foreign_key(None, 'department', 'user', ['created_user_id'], ['id'])
    op.create_foreign_key(None, 'department', 'user', ['updated_user_id'], ['id'])
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.drop_constraint(None, 'department', type_='foreignkey')
    op.drop_constraint(None, 'department', type_='foreignkey')
    op.drop_index(op.f('ix_department_id'), table_name='department')
    op.create_index('id_2', 'department', ['id'], unique=False)
    op.alter_column('department', 'description',
               existing_type=mysql.TEXT(),
               nullable=False)
    op.alter_column('department', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=False)
    op.drop_column('department', 'updated_user_id')
    op.drop_column('department', 'created_user_id')
    op.drop_column('department', 'updated_time')
    op.drop_column('department', 'created_time')
   
    # ### end Alembic commands ###
