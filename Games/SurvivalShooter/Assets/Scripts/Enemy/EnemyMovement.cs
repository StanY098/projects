using UnityEngine;
using System.Collections;
using UnityEngine.SceneManagement;

public class EnemyMovement : MonoBehaviour
{
    Transform player;
    PlayerHealth playerHealth;
    EnemyHealth enemyHealth;
    UnityEngine.AI.NavMeshAgent nav;
    EnemyHealth bossHealth;
    bool activate;
    Animator anim;

    void Awake ()
    {
        player = GameObject.FindGameObjectWithTag ("Player").transform;
        playerHealth = player.GetComponent <PlayerHealth> ();
        enemyHealth = GetComponent <EnemyHealth> ();
        nav = GetComponent <UnityEngine.AI.NavMeshAgent> ();
        activate = false;
        anim = GetComponent<Animator>();
    }


    void Update ()
    {
        if (enemyHealth.currentHealth > 0 && playerHealth.currentHealth > 0)
        {

            nav.SetDestination(player.position);
        }
        else
        {
            nav.enabled = false;
        }
        if(this.gameObject == GameObject.FindGameObjectWithTag("Boss") && enemyHealth.currentHealth < 1000 && SceneManager.GetActiveScene().buildIndex == 6 && !activate)
        {
            enemyHealth.currentHealth = 2500;
            nav.speed = 4;
            anim.SetTrigger("Angry");
            Component halo = GetComponent("Halo");
            halo.GetType().GetProperty("enabled").SetValue(halo, true, null);
            GetComponent<EnemyAttack>().attackDamage = 25;
            GetComponent<Transform>().transform.localScale = GetComponent<Transform>().transform.localScale * 1.5f;
            activate = true;
        }
    }
}
