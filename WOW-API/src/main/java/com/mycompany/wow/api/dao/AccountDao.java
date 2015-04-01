/**********************************
 * AccountDao - This class connects
 * the java objects to the database
 * and can retrieve, create, update
 * and delete data.
 **********************************/
package com.mycompany.wow.api.dao;

import com.mycompany.wow.api.WOWAccount;
import com.mycompany.wow.api.WOWCharacter;
import com.mycompany.wow.api.util.HibernateUtil;
import java.util.List;
import org.hibernate.Hibernate;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

/**
 *
 * @author Matt Bessey
 */
public class AccountDao {
    
    SessionFactory sessionFactory = HibernateUtil.getSessionFactory();
    
    //getAccountByName(String name) - This method retrieves a single account
    //from the database with the matching account name,
    public WOWAccount getAccountByName(String name) {
        WOWAccount account = null;
        Session session = null;
        
        try {
            session = sessionFactory.openSession();
            session.beginTransaction();
            account = (WOWAccount) session.createQuery("from WOWAccount a where a.name = :name").setParameter("name", name).uniqueResult();
            
            Hibernate.initialize(account.getCharacters().get(0).getName());
               
            session.getTransaction().commit();
        }
        catch(Exception ex){
            System.out.println(ex);
            if (session != null) {
                session.getTransaction().rollback();
            }
        }
        finally {
            if (session != null) {
                session.close();
            }     
        }
        
        return account;   
    }
    
    //getAllAccounts() - Retrieves all accounts from the database.
    public List<WOWAccount> getAllAccounts() {
        List<WOWAccount> accounts = null;
        Session session = null;
        
        try {
            session = sessionFactory.openSession();
            session.beginTransaction();
            
            String queryString = "from WOWAccount";
            
            Query query = session.createQuery(queryString);        
            accounts = query.list();
            
            for (WOWAccount account : accounts) {
                Hibernate.initialize(account.getCharacters().get(0).getName());
             }
            
            session.getTransaction().commit();
        }
        
        catch(Exception ex){
            System.out.println(ex);
            
            
            if (session != null) {
                session.getTransaction().rollback();
            }
        }
        
        finally {
            if (session != null) {
                session.close();
            }            
        }
        
        return accounts;
    }
    
    //saveAccount(WOWAccount account) - Saves an new account in the database.
    public boolean saveAccount(WOWAccount account) {
        Session session = null;
        boolean hasErrors = false;
        
        try {
            session = sessionFactory.openSession();
            session.beginTransaction();
            session.saveOrUpdate(account);
            
            session.getTransaction().commit();
        }
        
        catch(Exception ex) {
            System.out.println(ex);
            
            if (session != null) {
                session.getTransaction().rollback();
            }
            hasErrors = true;
        }
        
        finally {
            if (session != null) {
                session.close();
            }      
        }
        
        return hasErrors;
    }
    
    //saveCharacter(WOWCharacter character) - Save a new character in the database;
    public boolean saveCharacter(WOWCharacter character) {
        Session session = null;
        boolean hasErrors = false;
        
        try {
            session = sessionFactory.openSession();
            session.beginTransaction();
            session.saveOrUpdate(character); 
          
            session.getTransaction().commit();
        }
        
        catch(Exception ex) {
            System.out.println(ex);
            
            if (session != null) {
                session.getTransaction().rollback();
            }
            hasErrors = true;
        }
        
        finally {
            if (session != null) {
                session.close();
            }      
        }
        
        return hasErrors;
    }
    
    //deleteAccount(WOWAccount account) - Toggles the isActive boolean on the 
    //provided account.
    public boolean deleteAccount(WOWAccount account) {
        Session session = null;
        boolean hasErrors = false;
        
        try {
            session = sessionFactory.openSession();
            session.beginTransaction();
            account.setIsActive(!account.getIsActive());
            session.saveOrUpdate(account);
          
            session.getTransaction().commit();
        }
        
        catch(Exception ex) {
            System.out.println(ex);
            
            if (session != null) {
                session.getTransaction().rollback();
            }
            hasErrors = true;
        }
        finally {
            if (session != null) {
                session.close();
            }      
        }
        
        return hasErrors;
    }
    
    //deleteCharacter(WOWCharacter character) - Toggles the isActive boolean  
    //on the provided character.
    public boolean deleteCharacter(WOWCharacter character) {
        Session session = null;
        boolean hasErrors = false;
        
        try {
            session = sessionFactory.openSession();
            session.beginTransaction();
            character.setIsActive(!character.getIsActive());
            session.saveOrUpdate(character);
          
            session.getTransaction().commit();
        }
        
        catch(Exception ex) {
            System.out.println(ex);
            
            if (session != null) {
                session.getTransaction().rollback();
            }
            hasErrors = true;
        }
        
        finally {
            if (session != null) {
                session.close();
            }      
        }
        
        return hasErrors;
    }
}
