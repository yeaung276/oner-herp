import setup
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
import os

engine = create_engine(setup.SQLALCHEMY_DATABASE_URL)

SessionLocal = sessionmaker(bind=engine, autocommit=False, autoflush=False)

def get_db():
    db = SessionLocal()
    try:
        yield db
        db.commit()
    except Exception:
        db.rollback()
        raise
    finally:
        db.close()