"""update position

Revision ID: c062f6a1c649
Revises: 3e12aba4bcad
Create Date: 2021-12-08 14:50:35.768919

"""
from alembic import op
import sqlalchemy as sa
from sqlalchemy.dialects import mysql

# revision identifiers, used by Alembic.
revision = 'c062f6a1c649'
down_revision = '3e12aba4bcad'
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
   
    op.add_column('position', sa.Column('created_time', sa.DateTime(timezone=True), nullable=True))
    op.add_column('position', sa.Column('updated_time', sa.DateTime(timezone=True), nullable=True))
    op.add_column('position', sa.Column('created_user_id', sa.BigInteger(), nullable=False))
    op.add_column('position', sa.Column('updated_user_id', sa.BigInteger(), nullable=False))
    op.execute("UPDATE position SET created_user_id = 1")
    op.execute("UPDATE position SET updated_user_id = 1")
    op.alter_column('position', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=True)
    op.create_index(op.f('ix_position_id'), 'position', ['id'], unique=False)
    op.create_foreign_key(None, 'position', 'user', ['updated_user_id'], ['id'])
    op.create_foreign_key(None, 'position', 'user', ['created_user_id'], ['id'])
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.drop_constraint(None, 'position', type_='foreignkey')
    op.drop_constraint(None, 'position', type_='foreignkey')
    op.drop_index(op.f('ix_position_id'), table_name='position')
    op.alter_column('position', 'name',
               existing_type=mysql.VARCHAR(length=255),
               nullable=False)
    op.drop_column('position', 'updated_user_id')
    op.drop_column('position', 'created_user_id')
    op.drop_column('position', 'updated_time')
    op.drop_column('position', 'created_time')
    
    # ### end Alembic commands ###
