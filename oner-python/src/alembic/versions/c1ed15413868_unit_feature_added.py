"""unit feature added

Revision ID: c1ed15413868
Revises: cf538f6d5d1b
Create Date: 2021-12-16 10:05:29.400849

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = 'c1ed15413868'
down_revision = 'cf538f6d5d1b'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.create_table('operation_usage_item',
    sa.Column('id', sa.Integer(), autoincrement=True, nullable=False),
    sa.Column('created_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('operation_id', sa.Integer(), nullable=True),
    sa.Column('pharmacy_item_id', sa.BigInteger(), nullable=True),
    sa.Column('quantity', sa.Integer(), nullable=True),
    sa.Column('unit', sa.String(length=255), nullable=True),
    sa.Column('created_user_id', sa.BigInteger(), nullable=False),
    sa.Column('updated_user_id', sa.BigInteger(), nullable=False),
    sa.ForeignKeyConstraint(['created_user_id'], ['user.id'], ),
    sa.ForeignKeyConstraint(['operation_id'], ['operation.id'], ),
    sa.ForeignKeyConstraint(['pharmacy_item_id'], ['pharmacy_item.id'], ),
    sa.ForeignKeyConstraint(['updated_user_id'], ['user.id'], ),
    sa.PrimaryKeyConstraint('id')
    )
    op.create_index(op.f('ix_operation_usage_item_id'), 'operation_usage_item', ['id'], unique=False)
    op.create_table('unit',
    sa.Column('id', sa.Integer(), autoincrement=True, nullable=False),
    sa.Column('created_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('pharmacy_item_id', sa.BigInteger(), nullable=True),
    sa.Column('name', sa.String(length=255), nullable=False),
    sa.Column('uom_equavilent', sa.Float(), nullable=True),
    sa.Column('created_user_id', sa.BigInteger(), nullable=False),
    sa.Column('updated_user_id', sa.BigInteger(), nullable=False),
    sa.ForeignKeyConstraint(['created_user_id'], ['user.id'], ),
    sa.ForeignKeyConstraint(['pharmacy_item_id'], ['pharmacy_item.id'], ),
    sa.ForeignKeyConstraint(['updated_user_id'], ['user.id'], ),
    sa.PrimaryKeyConstraint('id')
    )
    op.create_index(op.f('ix_unit_id'), 'unit', ['id'], unique=False)
   
    op.add_column('operation', sa.Column('state', sa.Enum('open', 'close', name='state'), nullable=True))

    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.drop_column('operation', 'state')

    op.drop_index(op.f('ix_unit_id'), table_name='unit')
    op.drop_table('unit')
    op.drop_index(op.f('ix_operation_usage_item_id'), table_name='operation_usage_item')
    op.drop_table('operation_usage_item')
    # ### end Alembic commands ###
