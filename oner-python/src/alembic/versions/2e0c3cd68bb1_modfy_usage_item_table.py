"""modfy usage item table

Revision ID: 2e0c3cd68bb1
Revises: 11fc3ca0cc86
Create Date: 2021-12-28 15:58:35.283058

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = '2e0c3cd68bb1'
down_revision = '11fc3ca0cc86'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
  

    op.add_column('operation_usage_item', sa.Column('inventory_id', sa.Integer(), nullable=False))
   
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###

    op.drop_column('operation_usage_item', 'inventory_id')

    
    # ### end Alembic commands ###
