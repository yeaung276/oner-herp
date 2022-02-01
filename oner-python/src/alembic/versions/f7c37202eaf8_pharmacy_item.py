"""pharmacy item 

Revision ID: f7c37202eaf8
Revises: 23bf4dce7e85
Create Date: 2021-11-25 15:57:57.242381

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = 'f7c37202eaf8'
down_revision = '23bf4dce7e85'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.alter_column('pharmacy_item', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.alter_column('pharmacy_item', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('pharmacy_item', 'pharmacy_category_id',
               existing_type=mysql.BIGINT(),
               nullable=True)
    op.alter_column('pharmacy_item', 'universal_product_code',
               existing_type=mysql.VARCHAR(length=50),
               comment=None,
               existing_comment='Barcode',
               existing_nullable=True)
    op.create_index(op.f('ix_pharmacy_item_id'), 'pharmacy_item', ['id'], unique=False)
    op.create_foreign_key(None, 'pharmacy_item', 'user', ['created_user_id'], ['id'])
    op.drop_column('pharmacy_item', 'supplier_id')
    op.drop_column('pharmacy_item', 'purchase_price')
    op.drop_column('pharmacy_item', 'packaging')
    op.drop_column('pharmacy_item', 'po_uom')
    op.drop_column('pharmacy_item', 'brand_name')
    op.drop_column('pharmacy_item', 'sale_price')
    op.drop_column('pharmacy_item', 'unit_conversion_id')
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.add_column('pharmacy_item', sa.Column('unit_conversion_id', mysql.INTEGER(), autoincrement=False, nullable=True))
    op.add_column('pharmacy_item', sa.Column('sale_price', mysql.FLOAT(), nullable=True))
    op.add_column('pharmacy_item', sa.Column('brand_name', mysql.VARCHAR(length=255), nullable=False))
    op.add_column('pharmacy_item', sa.Column('po_uom', mysql.VARCHAR(length=255), nullable=True))
    op.add_column('pharmacy_item', sa.Column('packaging', mysql.VARCHAR(length=255), nullable=True))
    op.add_column('pharmacy_item', sa.Column('purchase_price', mysql.FLOAT(), nullable=True))
    op.add_column('pharmacy_item', sa.Column('supplier_id', mysql.BIGINT(), autoincrement=False, nullable=False))
    op.drop_constraint(None, 'pharmacy_item', type_='foreignkey')
    op.drop_index(op.f('ix_pharmacy_item_id'), table_name='pharmacy_item')
    op.alter_column('pharmacy_item', 'universal_product_code',
               existing_type=mysql.VARCHAR(length=50),
               comment='Barcode',
               existing_nullable=True)
    op.alter_column('pharmacy_item', 'pharmacy_category_id',
               existing_type=mysql.BIGINT(),
               nullable=False)
    op.alter_column('pharmacy_item', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('pharmacy_item', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
   
    # ### end Alembic commands ###