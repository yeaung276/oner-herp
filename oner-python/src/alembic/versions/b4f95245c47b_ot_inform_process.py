"""ot inform process

Revision ID: b4f95245c47b
Revises: 64e730b15634
Create Date: 2021-12-13 11:47:40.494167

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = 'b4f95245c47b'
down_revision = '64e730b15634'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.create_table('operation',
    sa.Column('id', sa.Integer(), autoincrement=True, nullable=False),
    sa.Column('created_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('patient_id', sa.BigInteger(), nullable=True),
    sa.Column('anasthetic', sa.String(length=255), nullable=True),
    sa.Column('surgeon', sa.String(length=255), nullable=True),
    sa.Column('anasthesia', sa.String(length=255), nullable=True),
    sa.Column('room', sa.Enum('room_A', 'room_B', 'room_C', 'room_D', name='operationroom'), nullable=True),
    sa.Column('start_time', sa.DateTime(), nullable=True),
    sa.Column('end_time', sa.DateTime(), nullable=True),
    sa.Column('outcome', sa.String(length=255), nullable=True),
    sa.Column('created_user_id', sa.BigInteger(), nullable=False),
    sa.Column('updated_user_id', sa.BigInteger(), nullable=False),
    sa.ForeignKeyConstraint(['created_user_id'], ['user.id'], ),
    sa.ForeignKeyConstraint(['patient_id'], ['patient.id'], ),
    sa.ForeignKeyConstraint(['updated_user_id'], ['user.id'], ),
    sa.PrimaryKeyConstraint('id')
    )
    op.create_index(op.f('ix_operation_id'), 'operation', ['id'], unique=False)
    op.create_table('ot_inform',
    sa.Column('id', sa.Integer(), autoincrement=True, nullable=False),
    sa.Column('created_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True),
    sa.Column('patient_id', sa.BigInteger(), nullable=True),
    sa.Column('inpatient_id', sa.Integer(), nullable=True),
    sa.Column('operation_datetime', sa.DateTime(), nullable=True),
    sa.Column('anasthetic', sa.String(length=255), nullable=True),
    sa.Column('surgeon', sa.String(length=255), nullable=True),
    sa.Column('diagnosis', sa.String(length=255), nullable=True),
    sa.Column('operation', sa.String(length=255), nullable=True),
    sa.Column('unit_of_blood_reserved', sa.String(length=255), nullable=True),
    sa.Column('lab_order_id', sa.Integer(), nullable=True),
    sa.Column('created_user_id', sa.BigInteger(), nullable=False),
    sa.Column('updated_user_id', sa.BigInteger(), nullable=False),
    sa.ForeignKeyConstraint(['created_user_id'], ['user.id'], ),
    sa.ForeignKeyConstraint(['patient_id'], ['patient.id'], ),
    sa.ForeignKeyConstraint(['updated_user_id'], ['user.id'], ),
    sa.PrimaryKeyConstraint('id')
    )
    op.create_index(op.f('ix_ot_inform_id'), 'ot_inform', ['id'], unique=False)
    
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    
    op.drop_index(op.f('ix_ot_inform_id'), table_name='ot_inform')
    op.drop_table('ot_inform')
    op.drop_index(op.f('ix_operation_id'), table_name='operation')
    op.drop_table('operation')
    # ### end Alembic commands ###