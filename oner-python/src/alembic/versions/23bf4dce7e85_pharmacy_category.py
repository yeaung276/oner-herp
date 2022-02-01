"""pharmacy_category

Revision ID: 23bf4dce7e85
Revises: d856920fa5ef
Create Date: 2021-11-25 13:11:30.464547

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = '23bf4dce7e85'
down_revision = 'd856920fa5ef'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    
    op.add_column('pharmacy_category', sa.Column('description', sa.String(255), nullable=True))
    op.alter_column('pharmacy_category', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.alter_column('pharmacy_category', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('pharmacy_category', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=True)
    op.create_index(op.f('ix_pharmacy_category_id'), 'pharmacy_category', ['id'], unique=False)
    op.create_foreign_key(None, 'pharmacy_category', 'user', ['created_user_id'], ['id'])
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.drop_constraint(None, 'pharmacy_category', type_='foreignkey')
    op.drop_index(op.f('ix_pharmacy_category_id'), table_name='pharmacy_category')
    op.alter_column('pharmacy_category', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=False)
    op.alter_column('pharmacy_category', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('pharmacy_category', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.drop_column('pharmacy_category', 'description')
    
    # ### end Alembic commands ###
