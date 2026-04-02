import java.util.Properties;
import javax.mail.Authenticator;
import javax.mail.Message;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
public class MailAuthSMTP {

 private static String SMTP_HOST_NAME = "<HostName>";
 private static final String SMTP_AUTH_USER = "<UserName>"; //user's email address
 private static final String SMTP_AUTH_PWD = "<Password>"; //Password
 public static void main(String[] args) throws Exception {


 new MailAuthSMTP().test1("<To mailid>"); // Recipient email address

 }
 public void test1(String email) throws Exception {
 Properties props = new Properties();
 props.put("mail.transport.protocol", "smtp");
 props.put("mail.smtp.host", SMTP_HOST_NAME);
 props.put("mail.smtp.auth", "true");
 props.put("mail.smtp.starttls.enable", "true");
 props.put("mail.smtp.ssl.protocols", "TLSv1.2");
 props.put("mail.smtp.port", "25");
 props.put("mail.smtp.debug", "true");
 Authenticator auth = new SMTPAuthenticator();
 Session mailSession = Session.getDefaultInstance(props, auth);
 Transport transport = mailSession.getTransport();
 String msg = "Test message";
 MimeMessage message = new MimeMessage(mailSession);
 message.setContent(msg, "text/html; charset=utf-8");
 message.setSubject("Testing SSL and authentication over port 25 from Host " + SMTP_HOST_NAME);
 message.setFrom(new InternetAddress("<From MailID>")); // from address
 message.addRecipient(Message.RecipientType.TO, new InternetAddress(email));
 transport.connect();
 transport.sendMessage(message,message.getRecipients(Message.RecipientType.TO));
 transport.close();
 }
 private class SMTPAuthenticator extends javax.mail.Authenticator {
 public PasswordAuthentication getPasswordAuthentication() {
 String username = SMTP_AUTH_USER;
 String password = SMTP_AUTH_PWD;
 return new PasswordAuthentication(username, password);
 }
 }
}