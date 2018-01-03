using UnityEngine;
using UnityEngine.SceneManagement;

public class GameOverManager : MonoBehaviour
{
    public PlayerHealth playerHealth;       // Reference to the player's health.
    public EnemyHealth bossHealth;
    public float nextDelay = 1000000f;

    Animator anim;                          // Reference to the animator component.

    void Awake ()
    {
        // Set up the reference.
        anim = GetComponent <Animator> ();
    }


    void Update ()
    {
        // If the player has run out of health...
        if(playerHealth.currentHealth <= 0)
        {
          // ... tell the animator the game is over.
            anim.SetTrigger ("GameOver");
        }
        else if(bossHealth.currentHealth <= 0)
        {
            anim.SetTrigger("Win");
        }
    }
}

