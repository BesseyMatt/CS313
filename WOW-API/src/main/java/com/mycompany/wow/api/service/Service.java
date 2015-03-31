/**********************************
 * Services - This class contains
 * the bulk of the projects logic
 * and contains the URL calls for
 * all the GETS, POSTS, and DELETES
 **********************************/
package com.mycompany.wow.api.service;

import com.mycompany.wow.api.WOWCharacter;
import com.mycompany.wow.api.WOWAccount;
import com.mycompany.wow.api.dao.AccountDao;
import java.util.ArrayList;
import javax.ws.rs.core.MediaType;
import java.util.List;
import javax.ws.rs.Consumes;
import javax.ws.rs.DELETE;
import javax.ws.rs.Produces;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import org.json.JSONException;
import org.json.JSONObject;

/**
 *
 * @author Matt Bessey
 */
@Path("service") //the base path for all the services
public class Service {
    
    private AccountDao accountDao = new AccountDao();
    
    //returnTheAboutPage() - This method returns the about me page; 
    //including my name and a link to the source code
    @GET
    @Path("about/")
    @Produces(MediaType.APPLICATION_JSON)
    public String returnTheAboutPage(){
        return "{ \"author\" : \"Matthew Bessey Applicant\", \"source\" : \"https://github.com/BesseyMatt/CS313/WOW-API\" }";
    }
    
    //getCharactersfromAccountJSON() - This method returns a List of 
    //all Character objects in an account.
    @GET
    @Path("account/{accountName}/characters/")
    @Produces(MediaType.APPLICATION_JSON)
    public List<WOWCharacter> getCharactersfromAccountJSON(@PathParam("accountName")String accountName) {
        
            //returns null if no account with that name exists
            if (accountDao.getAccountByName(accountName) == null) { 
                return null;
            }
        
        return accountDao.getAccountByName(accountName).getCharacters();
    }
    
    //getAllAccountsInJSON() - This method return a list of all accounts objects.
    @GET
    @Path("account")
    @Produces(MediaType.APPLICATION_JSON)
    public List<WOWAccount> getAllAccountsInJSON() {
        return accountDao.getAllAccounts();
    }
    
    //saveNewAccount(String name) - This method creates a new account with
    //the provided account Name. 
    @POST
    @Path("/account")
    @Consumes(MediaType.APPLICATION_JSON)
    public String saveNewAccount(String name) throws JSONException{
        
        try {
            JSONObject json = new JSONObject(name);
            String accountName = json.get("name").toString();
       
            ArrayList<WOWAccount> allAccounts = (ArrayList<WOWAccount>) accountDao.getAllAccounts();

            WOWAccount account = new WOWAccount();
            account.setName(accountName);
            account.setLink("jbossews-besseym.rhcloud.com/WOW-API/rest/service/account" + accountName);
            account.setIsActive(true);

            //This ensure that the account name is unique
            for (WOWAccount singleAccount : allAccounts)
            {
                if (singleAccount.getName().equals(accountName)) {
                    JSONObject returnJSON = new JSONObject();
                    return returnJSON.put("ERROR", "Account Name Already Exists").toString();
                }
            }

            if(!accountDao.saveAccount(account)) {
                int id = accountDao.getAccountByName(accountName).getAccountId();

                JSONObject returnJSON = new JSONObject();

                return returnJSON.put("account_id", id).toString();
            }
            
            else {
                JSONObject returnJSON = new JSONObject();

                return returnJSON.put("ERROR", "account has not been saved").toString();
            }
         }
        
        catch (JSONException ex) {
              return "{ \"ERROR\" : \"The Provided JSON has invalid syntax\" }";
        }
        
    }
    
    //deleteAccount(String name) - This method deletes an account. However, since
    //the ability to delete and undelete characters exist, this method assumes that
    //characters should not be deleted perminately in any way thus an account can
    //be deleted and undeleted as well
    @DELETE 
    @Path("account/{accountName}")
    @Produces(MediaType.APPLICATION_JSON)
    public String deleteAccount(@PathParam("accountName") String name) {
        
        WOWAccount accountToDelete = accountDao.getAccountByName(name);
        
        List<WOWCharacter> characters = accountToDelete.getCharacters();
        
        //This prevents an account from being deleted if a character in 
        //that account is still active
        for(WOWCharacter singleCharacter : characters) {
            if (singleCharacter.getIsActive()) {
                return "{ \"ERROR\" : \"Account can't be deleted since at least one character is still active\" }";
            }
        }
        
      
        if (!accountDao.deleteAccount(accountToDelete)) {
            
            //Toggles between is active and is not active to delete/undelete an account
            if (!accountToDelete.getIsActive()) {
                return "{ \"status\" : \"Account has been deleted. This account can be reactivated by making this call again.\" }";
            }
            
            else {
                return "{ \"status\" : \"Account can be reactivated. It can be deleted again if no active characters exist.\" }"; 
            }
        }
        else {
            return "{ \"ERROR\" : \"Account can't be deleted\" }";
        }    
    }
    
    //deleteCharacter(String accountName, String characterName) - The method deletes 
    //and undeletes Character. This fulfills the rule that 'A player should be able 
    //to delete and undelete characters.'
    @DELETE 
    @Path("account/{accountName}/characters/{characterName}")
    @Produces(MediaType.APPLICATION_JSON)
    public String deleteCharacter(@PathParam("accountName") String accountName, @PathParam("characterName") String characterName) {
        
        WOWAccount account = accountDao.getAccountByName(accountName);
        
        //This prevents a character from being reactivated without reactivating 
        //the account the character is in.
        if (!account.getIsActive()) {
            return "{ \"ERROR\" : \"This character cannot be reactivated since the account it is in is currently inactive\" }";     
        }            
        
        WOWCharacter characterToDelete = null;
        
        for (WOWCharacter singleCharacter : account.getCharacters()) {
            if (singleCharacter.getName().toLowerCase().equals(characterName.toLowerCase())) {
                characterToDelete = singleCharacter;
                break;
            }
        }
        
        //This prevents a character from being reactivated if a character of the
        //other faction is currently active on the account
        for (WOWCharacter singleCharacter : account.getCharacters()) {
            
            if (singleCharacter.getIsActive() && 
                    !singleCharacter.getFaction().toLowerCase().equals(characterToDelete.getFaction().toLowerCase())) {
                    return "{ \"ERROR\" : \"This character cannot be reactivated since a current active character belongs to a different faction\" }";
            }
            
        }
        
        if (!accountDao.deleteCharacter(characterToDelete)) {
            
            //Toggles between is active and is not active to delete/undelete an character
            if (!characterToDelete.getIsActive()) {
                return "{ \"status\" : \"Character has been deleted, but can be undeleted by making this call again\" }";
            }
            
            else {
                 return "{ \"status\" : \"Character has been undeleted, but can be deleted again\" }"; 
            }
        }
        
        else {
            return "{ \"ERROR\" : \"Character can't be deleted\" }";
        }    
    }
    
    //addCharacter(String accountName, String jsonobject) - This method adds a 
    //Character to an existing account
    @POST 
    @Path("/account/{accountName}/characters/")
    @Produces(MediaType.APPLICATION_JSON)
    public String addCharacter(@PathParam("accountName") String accountName, String jsonobject) throws JSONException {
       
        WOWAccount account;
        account = accountDao.getAccountByName(accountName);
       
         //This prevents a character from being added into an inactive account.
        if (!account.getIsActive()) {
             return "{ \"ERROR\" : \"A new character cannot be added to an inactive account, reactivate this account to add a new character.\" }";           
        }
        
        try {
            JSONObject json = new JSONObject(jsonobject);
        
            WOWCharacter newCharacter;
            newCharacter = new WOWCharacter(json.get("name").toString(), json.get("race").toString(), json.get("class").toString(), json.get("faction").toString(), json.getInt("level"), true, account);

            //This check if duplicate name to the new character already exists
             for (WOWCharacter singleCharacter : account.getCharacters()) {

                if (singleCharacter.getName().toLowerCase().equals(newCharacter.getName().toLowerCase())) {

                    return "{ \"ERROR\" : \"This new character cannot be created since a character with the same name exists in the database.\" }";        
                }
            }
            
            //Check if the new character follows all the required rules
            String errorString = isAnyRulesBroken(account, newCharacter);

            if(errorString.equals("")) {

                if (!accountDao.saveCharacter(newCharacter)) {

                    int id = -1;
                    for (WOWCharacter character : accountDao.getAccountByName(accountName).getCharacters()) {
                        if (character.getName().equals(json.get("name").toString()))
                           id = character.getCharacterId();
                    }

                    if (id != -1) {
                        JSONObject returnJSON = new JSONObject();

                        return returnJSON.put("character_id", id).toString();
                    }

                    else {
                        JSONObject returnJSON = new JSONObject();

                        return returnJSON.put("ERROR", "Could not create the new character").toString();
                    }
                }
                else {
                    JSONObject returnJSON = new JSONObject();    
                    return returnJSON.put("ERROR", "Could not create the new character").toString();     
                } 
            }
            return errorString;
        }
        
        catch (JSONException ex) {
              return "{ \"ERROR\" : \"The Provided JSON has invalid syntax\" }";
        }
    }
    
    //isAnyRulesBroken(WOWAccount account, WOWCharacter character) - This method
    //works as a helper function to validate that each of the required rules are
    //met before adding a new character into the database
    public String isAnyRulesBroken(WOWAccount account, WOWCharacter character) {
        
        String faction = character.getFaction().toLowerCase();
        String race = character.getRace().toLowerCase();
        String classType = character.getClassType().toLowerCase();
        int level = character.getLevel();
        
        //Rule #1: Orc, Tauren, and Blood Elf races are exclusively Horde.
        if (faction.equals("horde")) {
                
                if (!(race.equals("orc") || race.equals("tauren") || race.equals("blood elf")))
                    return "{ \"ERROR\" : \"Invalid race for the Horde Faction\" }";        
            }
                
        //Rule #2: Human, Gnome, and Worgen races are exclusively Alliance.
        else if (faction.equals("alliance")) {
            
                if (!(race.equals("human") || race.equals("gnome") || race.equals("worgen")))
                    return "{ \"ERROR\" : \"Invalid race for the Alliance Faction\" }";        
            }
        
        else { //Invalid Faction
            return "{ \"ERROR\" : \"Invalid Faction: Faction must be Horde or Alliance\" }";
        }
        
        //Rule #3: Check the provided class is a valid class
        if (!(classType.equals("druid") || classType.equals("mage") || classType.equals("warrior") || classType.equals("death knight"))) {
            return "{ \"ERROR\" : \"Invalid Class: Characters must be one of the following: Warrior, Mage, Death Knight, or Druid\" }";          
        }
        
        //Rule #4: Only Taurens and Worgen can be Druids.
        if (classType.equals("druid") ) {
            
            if (!(race.equals("tauren") || race.equals("worgen"))) {
                return "{ \"ERROR\" : \"Invalid Class: Only Taurens and Worgens can be Druids\" }";  
            }
        }
        
        //Rule #5: Blood Elves cannot be Warriors.
        if (race.equals("blood elf") && classType.equals("warrior")) {
             return "{ \"ERROR\" : \"Invalid Class: Blood Elves cannot be Warriors\" }";      
        }
        
        //Rule #6: Per the assignment explanation, all characters must be level 1 - 85.
        if (level < 1 || level > 85) {
             return "{ \"ERROR\" : \"Invalid Level: For this API all Characters must be between level 1 and 85\" }";      
        }
        
        //Rule #7: A player can only have all Horde or all Alliance active characters.
        if (account.getCharacters() != null) {
            
            List<WOWCharacter> allCharacters = account.getCharacters();
            
            for (WOWCharacter singleCharacter : allCharacters) {
                if (singleCharacter.getIsActive() && !faction.equals(singleCharacter.getFaction().toLowerCase())) {
                    return "{ \"ERROR\" : \"Invalid Character Faction for this Account: All active characters must have the same faction\" }";      
                }
            }
        }
        
        return "";
    }
}
