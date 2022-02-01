"""patient modf for ot inform

Revision ID: cf538f6d5d1b
Revises: d4d0fbce36a2
Create Date: 2021-12-13 15:43:25.248099

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = 'cf538f6d5d1b'
down_revision = 'd4d0fbce36a2'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
   
    op.add_column('patient', sa.Column('created_user_id', sa.BigInteger(), nullable=False))
    op.add_column('patient', sa.Column('updated_user_id', sa.BigInteger(), nullable=False))
    op.execute("UPDATE patient SET updated_user_id = 1")
    op.execute("UPDATE patient SET created_user_id = 1")
    op.execute("UPDATE patient SET date_of_birth=NULL WHERE date_of_birth=''")
    op.alter_column('patient', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.alter_column('patient', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=True,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('patient', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=True)
    op.alter_column('patient', 'age',
               existing_type=mysql.INTEGER(),
               nullable=True)
    op.alter_column('patient', 'phone',
               existing_type=mysql.VARCHAR(length=50),
               nullable=True)
    op.create_index(op.f('ix_patient_id'), 'patient', ['id'], unique=False)
    op.create_foreign_key(None, 'patient', 'user', ['created_user_id'], ['id'])
    op.create_foreign_key(None, 'patient', 'user', ['updated_user_id'], ['id'])
    op.drop_column('patient', 'status')
    op.drop_column('patient', 'region')
    op.drop_column('patient', 'nrc')
    op.drop_column('patient', 'township')

    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###

    op.add_column('patient', sa.Column('township', mysql.TEXT(), nullable=True))
    op.add_column('patient', sa.Column('nrc', mysql.VARCHAR(length=255), nullable=True))
    op.add_column('patient', sa.Column('region', mysql.TEXT(), nullable=True))
    op.add_column('patient', sa.Column('status', mysql.INTEGER(), autoincrement=False, nullable=True))
    op.drop_constraint(None, 'patient', type_='foreignkey')
    op.drop_constraint(None, 'patient', type_='foreignkey')
    op.drop_index(op.f('ix_patient_id'), table_name='patient')
    op.alter_column('patient', 'phone',
               existing_type=mysql.VARCHAR(length=50),
               nullable=False)
    op.alter_column('patient', 'age',
               existing_type=mysql.INTEGER(),
               nullable=False)
    op.alter_column('patient', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=False)
    op.alter_column('patient', 'updated_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
    op.alter_column('patient', 'created_time',
               existing_type=mysql.TIMESTAMP(),
               nullable=False,
               existing_server_default=sa.text('CURRENT_TIMESTAMP'))
    op.drop_column('patient', 'updated_user_id')
    op.drop_column('patient', 'created_user_id')
    
    # ### end Alembic commands ###