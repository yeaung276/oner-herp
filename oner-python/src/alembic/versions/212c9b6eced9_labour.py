"""labour

Revision ID: 212c9b6eced9
Revises: 123a8fca2610
Create Date: 2021-12-29 11:36:31.556112

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = '212c9b6eced9'
down_revision = '123a8fca2610'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.create_table('labour',
    sa.Column('id', sa.BigInteger(), autoincrement=True, nullable=False),
    sa.Column('created_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('patient_id', sa.BigInteger(), nullable=True),
    sa.Column('anasthetic', sa.String(255), nullable=True),
    sa.Column('surgeon', sa.String(255), nullable=True),
    sa.Column('anasthesia', sa.String(255), nullable=True),
    sa.Column('start_time', sa.DateTime(), nullable=True),
    sa.Column('end_time', sa.DateTime(), nullable=True),
    sa.Column('outcome', sa.String(255), nullable=True),
    sa.Column('state', sa.Enum('open', 'close', name='state'), nullable=True),
    sa.Column('created_user_id', sa.BigInteger(), nullable=False),
    sa.Column('updated_user_id', sa.BigInteger(), nullable=False),
    sa.ForeignKeyConstraint(['created_user_id'], ['user.id'], ),
    sa.ForeignKeyConstraint(['patient_id'], ['patient.id'], ),
    sa.ForeignKeyConstraint(['updated_user_id'], ['user.id'], ),
    sa.PrimaryKeyConstraint('id')
    )
    op.create_index(op.f('ix_labour_id'), 'labour', ['id'], unique=False)
    op.create_table('labour_usage_item',
    sa.Column('id', sa.BigInteger(), autoincrement=True, nullable=False),
    sa.Column('created_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('labour_id', sa.BigInteger(), nullable=True),
    sa.Column('pharmacy_item_id', sa.BigInteger(), nullable=True),
    sa.Column('inventory_id', sa.Integer(), nullable=True),
    sa.Column('quantity', sa.Integer(), nullable=True),
    sa.Column('unit', sa.String(255), nullable=True),
    sa.Column('created_user_id', sa.BigInteger(), nullable=False),
    sa.Column('updated_user_id', sa.BigInteger(), nullable=False),
    sa.ForeignKeyConstraint(['created_user_id'], ['user.id'], ),
    sa.ForeignKeyConstraint(['labour_id'], ['labour.id'], ),
    sa.ForeignKeyConstraint(['pharmacy_item_id'], ['pharmacy_item.id'], ),
    sa.ForeignKeyConstraint(['updated_user_id'], ['user.id'], ),
    sa.PrimaryKeyConstraint('id')
    )
    op.create_index(op.f('ix_labour_usage_item_id'), 'labour_usage_item', ['id'], unique=False)
    
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###

    op.drop_index(op.f('ix_labour_usage_item_id'), table_name='labour_usage_item')
    op.drop_table('labour_usage_item')
    op.drop_index(op.f('ix_labour_id'), table_name='labour')
    op.drop_table('labour')
    # ### end Alembic commands ###
