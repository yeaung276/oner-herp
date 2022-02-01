"""unit column name change

Revision ID: ff4f4724cf50
Revises: c1ed15413868
Create Date: 2021-12-16 10:20:32.605023

"""
from alembic import op
import sqlalchemy as sa


# revision identifiers, used by Alembic.
revision = 'ff4f4724cf50'
down_revision = 'c1ed15413868'
branch_labels = None
depends_on = None


def upgrade():
    op.alter_column('unit','uom_equavilent',existing_type=sa.Float(),nullable=True,new_column_name='uom_equivalent')


def downgrade():
    op.alter_column('unit','uom_equivalent',existing_type=sa.Float(),nullable=True,new_column_name='uom_equavilent')
